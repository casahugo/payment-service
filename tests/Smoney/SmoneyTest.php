<?php

declare(strict_types=1);

namespace App\Tests\Smoney;

use App\Entity\Transaction;
use App\Gateway\Request\Capture;
use App\Gateway\Request\Checkout;
use App\Gateway\Request\Prepare;
use App\Gateway\Request\Transaction as RequestTransaction;
use App\Gateway\Response\ResponseCheckout;
use App\Smoney\Action\CaptureAction;
use App\Smoney\Action\CheckoutAction;
use App\Smoney\Action\PrepareAction;
use App\Smoney\Action\TransactionAction;
use App\Smoney\Response\ResponseCapture;
use App\Smoney\Response\ResponsePrepare;
use App\Smoney\Response\ResponseTransaction;
use App\Smoney\Smoney;
use App\Storage\StorageInterface;
use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

class SmoneyTest extends TestCase
{
    private const REFERENCE = '72306889c68dfe6d8e3e65f02b4e33ae';
    private const TRANSACTION_ID = 1;

    public function testPrepareAction(): void
    {
        $transaction = (new Transaction())
            ->setId(static::TRANSACTION_ID)
            ->setReference(static::REFERENCE);

        $storage = $this->createMock(StorageInterface::class);
        $storage->method('saveTransaction')->willReturn($transaction);

        $router = $this->createMock(RouterInterface::class);
        $router->method('generate')->willReturn('http://website.com/return');

        $gateway = new Smoney([new PrepareAction()], $storage, $router);

        $request = new Request([], [
            'OrderId' => 'sandbox_1',
            'IsMine' => false,
            'Amount' => 1550,
            'UrlReturn' => 'http://website.com/return',
            'Require3DS' => true,
            'Extraparameters' => [
                'SystempayLanguage' => 'en',
            ],
            'PayerInfo' => [
                'Name' => 'John Smith',
                'Mail' => 'john@smith.com'
            ],
            'Beneficiary' => [
                'AppAccountId' => 5,
            ]
        ]);

        $response = $gateway->execute(new Prepare(
            $gateway->resolver()->resolvePrepare($request->request->all())
        ));

        static::assertInstanceOf(ResponsePrepare::class, $response);
        static::assertEquals(new ResponsePrepare($transaction, 'http://website.com/return'), $response);
    }

    public function testCaptureAction(): void
    {
        $transaction = (new Transaction())->setId(1)->setData([
            'UrlReturn' => 'http://www.return-site.com/returnURL/',
            'OrderId' => 'sandbox_1',
        ]);

        $storage = $this->createMock(StorageInterface::class);
        $storage->method('findTransaction')->willReturn($transaction);

        $gateway = new Smoney([new CaptureAction()], $storage, $this->createMock(RouterInterface::class));

        $response = $gateway->execute(new Capture($transaction->getId()));

        static::assertInstanceOf(ResponseCapture::class, $response);
        static::assertEquals(new ResponseCapture($transaction), $response);
    }

    public function testCheckoutAction(): void
    {
        $transaction = (new Transaction())
            ->setId(static::TRANSACTION_ID)
            ->setReference(static::REFERENCE)
        ;

        $storage = $this->createMock(StorageInterface::class);
        $storage->method('findTransaction')->willReturn($transaction);

        $gateway = new Smoney(
            [new CheckoutAction()],
            $storage,
            $this->createMock(RouterInterface::class)
        );

        /** @var ResponseCheckout $response */
        $response = $gateway->execute(new Checkout(['transactionId' => static::TRANSACTION_ID]));
        $exceptedResponse = new ResponseCheckout($transaction, new Uri(null));

        static::assertInstanceOf(ResponseCheckout::class, $response);
        static::assertEquals($exceptedResponse, $response);
        static::assertSame($exceptedResponse->getTransaction()->getReference(), static::REFERENCE);
        static::assertSame((string) $exceptedResponse->getAction(), '');
    }

    public function testTransactionAction(): void
    {
        $storage = $this->createMock(StorageInterface::class);
        $storage->method('findTransaction')->willReturn(
            (new Transaction())->setId(1)->setData([])
        );

        $gateway = new Smoney([new TransactionAction()], $storage, $this->createMock(RouterInterface::class));
        $transaction = $gateway->execute(new RequestTransaction(
            $gateway->resolver()->resolveTransaction(['reference' => 'sandbox_1'])
        ));

        static::assertInstanceOf(ResponseTransaction::class, $transaction);
    }
}
