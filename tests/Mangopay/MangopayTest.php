<?php

declare(strict_types=1);

namespace App\Tests\Mangopay;

use App\Entity\Transaction;
use App\Gateway\Request\Capture;
use App\Gateway\Request\Checkout;
use App\Gateway\Request\Prepare;
use App\Gateway\Request\Transaction as RequestTransaction;
use App\Gateway\Response\ResponseCheckout;
use App\Mangopay\Action\CheckoutAction;
use App\Mangopay\Action\CaptureAction;
use App\Mangopay\Action\PrepareAction;
use App\Mangopay\Action\TransactionAction;
use App\Mangopay\Mangopay;
use App\Mangopay\Response\ResponseCapture;
use App\Mangopay\Response\ResponsePrepare;
use App\Mangopay\Response\ResponseTransaction;
use App\Storage\StorageInterface;
use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

class MangopayTest extends TestCase
{
    private const REFERENCE = '72306889c68dfe6d8e3e65f02b4e33ae';
    private const TRANSACTION_ID = 1;

    public function testPrepareAction(): void
    {
        $storage = $this->createMock(StorageInterface::class);
        $storage->method('saveTransaction')->willReturn((new Transaction())->setId(1));

        $router = $this->createMock(RouterInterface::class);
        $router->method('generate')->willReturn('http://www.my-site.com/returnURL/');

        $gateway = new Mangopay([new PrepareAction()], $storage, $router);

        $data = [
            'Tag' => 'custom meta',
            'AuthorId' => '8494514',
            'CreditedUserId' => '8494514',
            'DebitedFunds' => [
                'Currency' => 'EUR',
                'Amount' => 12,
            ],
            'Fees' => [
                'Currency' => 'EUR',
                'Amount' => 12,
            ],
            'ReturnURL' => 'http://www.my-site.com/returnURL/',
            'CardType' => 'CB_VISA_MASTERCARD',
            'CreditedWalletId' => '8494559',
            'SecureMode' => 'DEFAULT',
            'Culture' => 'EN',
            'TemplateURLOptions' => [
                'Payline' => 'https://www.mysite.com/template/',
            ],
            'StatementDescriptor' => 'Mar2016',
        ];

        $response = $gateway->execute(new Prepare(
            $gateway->resolver()->resolvePrepare((new Request([], $data))->request->all())
        ));

        static::assertInstanceOf(ResponsePrepare::class, $response);
        static::assertEquals(new ResponsePrepare(1, 'http://www.my-site.com/returnURL/', $data), $response);
    }

    public function testCaptureAction(): void
    {
        $excepted = [
            'RedirectUrl' => 'http://www.return-site.com/returnURL/',
            'ReturnURL' => 'http://www.return-site.com/returnURL/',
        ];

        $storage = $this->createMock(StorageInterface::class);
        $storage->method('findTransaction')->willReturn(
            (new Transaction())->setId(1)->setData($excepted)
        );

        $gateway = new Mangopay([new CaptureAction()], $storage, $this->createMock(RouterInterface::class));

        $response = $gateway->execute(new Capture('1'));

        static::assertInstanceOf(ResponseCapture::class, $response);
        static::assertEquals(
            new ResponseCapture($excepted['RedirectUrl'], $excepted['ReturnURL'], 1),
            $response
        );
    }

    public function testCheckoutAction(): void
    {
        $storage = $this->createMock(StorageInterface::class);
        $storage->method('findTransaction')->willReturn(
            (new Transaction())
                ->setId(static::TRANSACTION_ID)
                ->setReference(static::REFERENCE)
        );

        $gateway = new Mangopay(
            [new CheckoutAction()],
            $storage,
            $this->createMock(RouterInterface::class)
        );

        /** @var ResponseCheckout $response */
        $response = $gateway->execute(new Checkout(['transactionId' => static::TRANSACTION_ID]));
        $exceptedResponse = new ResponseCheckout(static::REFERENCE, new Uri(null));

        static::assertInstanceOf(ResponseCheckout::class, $response);
        static::assertEquals($exceptedResponse, $response);
        static::assertSame($exceptedResponse->getReference(), static::REFERENCE);
        static::assertSame((string) $exceptedResponse->getAction(), '');
    }

    public function testTransactionAction(): void
    {
        $storage = $this->createMock(StorageInterface::class);
        $storage->method('findTransaction')->willReturn(
            (new Transaction())->setId(1)->setData([])
        );

        $gateway = new Mangopay([new TransactionAction()], $storage, $this->createMock(RouterInterface::class));
        $transaction = $gateway->execute(new RequestTransaction(
            $gateway->resolver()->resolveTransaction(['id' => 1])
        ));

        static::assertInstanceOf(ResponseTransaction::class, $transaction);
    }
}
