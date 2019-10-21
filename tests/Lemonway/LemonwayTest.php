<?php

declare(strict_types=1);

namespace App\Tests\Lemonway;

use App\Entity\Transaction;
use App\Gateway\Request\Capture;
use App\Gateway\Request\Checkout;
use App\Gateway\Request\Prepare;
use App\Gateway\Request\Transaction as RequestTransaction;
use App\Gateway\Response\ResponseCheckout;
use App\Lemonway\Action\CaptureAction;
use App\Lemonway\Action\CheckoutAction;
use App\Lemonway\Action\PrepareAction;
use App\Lemonway\Action\TransactionAction;
use App\Lemonway\Lemonway;
use App\Lemonway\Response\ResponseCapture;
use App\Lemonway\Response\ResponsePrepare;
use App\Lemonway\Response\ResponseTransaction;
use App\Storage\Storage;
use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;
use Symfony\Component\Routing\RouterInterface;

class LemonwayTest extends TestCase
{
    private const REFERENCE = '72306889c68dfe6d8e3e65f02b4e33ae';

    private const TRANSACTION_ID = 1;

    public function testPrepareAction(): void
    {
        $storage = $this->createMock(Storage::class);
        $storage->method('saveTransaction')->willReturn(
            (new Transaction())
                ->setId(1)
                ->setReference(static::REFERENCE)
        );

        $gateway = new Lemonway(
            [new PrepareAction()],
            $storage,
            $this->createMock(RouterInterface::class)
        );

        $request = new Request([], [
            'p' => array_merge($this->buildRequest(), [
                'wallet' => 123456,
                'amountTot' => 50.0,
                'wkToken' => 'tokenValid',
                'returnUrl' => urlencode('http://example.com/returnUrl'),
                'errorUrl' => urlencode('http://example.com/errorUrl'),
                'cancelUrl' => urlencode('http://example.com/cancelUrl'),
                'amountCom' => 0.,
                'comment' => 'Comments',
                'autoCommission' => '0',
                'isPreAuth' => '0',
                'delayedDays' => '0',
                'email' => 'contact@example.com'
            ])
        ]);

        $response = $gateway->execute(new Prepare(
            $gateway->resolver()->resolvePrepare($request->request->all())
        ));

        static::assertInstanceOf(ResponsePrepare::class, $response);
        static::assertEquals(new ResponsePrepare(static::REFERENCE, 1), $response);
    }

    public function testCaptureAction(): void
    {
        $returnUrl = 'http://example.com/returnUrl';
        $storage = $this->createMock(Storage::class);
        $storage->method('findTransaction')->willReturn(
            (new Transaction())
                ->setId(static::TRANSACTION_ID)
                ->setReference(static::REFERENCE)
                ->setData(['returnUrl' => $returnUrl])
        );

        $gateway = new Lemonway(
            [new CaptureAction()],
            $storage,
            $this->createMock(RouterInterface::class)
        );

        /** @var ResponseCapture $response */
        $response = $gateway->execute(new Capture(static::REFERENCE, false));
        $exceptedResponse = new ResponseCapture($returnUrl, static::TRANSACTION_ID, static::REFERENCE);

        static::assertInstanceOf(ResponseCapture::class, $response);
        static::assertEquals($exceptedResponse, $response);
        static::assertSame((string) $exceptedResponse->getRedirect(), (string) $response->getRedirect());
        static::assertSame((string) $exceptedResponse->getCallback(), (string) $response->getCallback());
    }

    public function testCheckoutAction(): void
    {
        $storage = $this->createMock(Storage::class);
        $storage->method('findTransaction')->willReturn(
            (new Transaction())
                ->setId(static::TRANSACTION_ID)
                ->setReference(static::REFERENCE)
        );

        $gateway = new Lemonway(
            [new CheckoutAction()],
            $storage,
            $this->createMock(RouterInterface::class)
        );

        /** @var ResponseCheckout $response */
        $response = $gateway->execute(new Checkout(['moneyInToken' => static::REFERENCE]));
        $exceptedResponse = new ResponseCheckout(static::REFERENCE, new Uri(null));

        static::assertInstanceOf(ResponseCheckout::class, $response);
        static::assertEquals($exceptedResponse, $response);
        static::assertSame($exceptedResponse->getReference(), static::REFERENCE);
        static::assertSame((string) $exceptedResponse->getAction(), '');
    }

    public function testTransactionAction(): void
    {
        $transaction = (new Transaction())
            ->setId(static::TRANSACTION_ID)
            ->setReference(static::REFERENCE)
            ->setData([
                'wallet' => '12',
                'amountTot' => 56.12,
                'comment' => 'Transaction wizaplace'
            ])
            ;

        $storage = $this->createMock(Storage::class);
        $storage->method('findTransaction')->willReturn($transaction);

        $gateway = new Lemonway(
            [new TransactionAction()],
            $storage,
            $this->createMock(RouterInterface::class)
        );

        /** @var ResponseTransaction $response */
        $response = $gateway->execute(new RequestTransaction($transaction));
        $exceptedResponse = new ResponseTransaction(
            static::TRANSACTION_ID,
            '12',
            56.12,
            'Transaction wizaplace'
        );

        static::assertInstanceOf(ResponseTransaction::class, $response);
        static::assertEquals($exceptedResponse, $response);
        static::assertSame($exceptedResponse->toArray(), $response->toArray());
    }

    public function testErrorAuthentication(): void
    {
        $storage = $this->createMock(Storage::class);
        $gateway = new Lemonway([new PrepareAction()], $storage, $this->createMock(RouterInterface::class));

        static::expectException(InvalidOptionsException::class);

        $request = new Request([], [
            'p' => [
                "wlPass" => "error",
                "wlLogin" => "login",
                "language" => "lang",
                "version" => "version",
                "walletIp" => "127.0.0.1",
                "walletUa" => "user-agent",
                'wallet' => 123456,
                'amountTot' => 50.0,
                'wkToken' => 'tokenValid',
                'returnUrl' => urlencode('http://example.com/returnUrl'),
                'errorUrl' => urlencode('http://example.com/errorUrl'),
                'cancelUrl' => urlencode('http://example.com/cancelUrl'),
                'amountCom' => 0.,
                'comment' => 'Comments',
                'autoCommission' => '0',
                'isPreAuth' => '0',
                'delayedDays' => '0',
                'email' => 'contact@example.com'
            ]
        ]);

        $response = $gateway->execute(new Prepare(
            $gateway->resolver()->resolvePrepare($request->request->all())
        ));
    }

    /** @return string[] */
    private function buildRequest(): array
    {
        return [
            "wlPass" => "password",
            "wlLogin" => "login",
            "version" => "version",
            "walletIp" => "127.0.0.1",
            "walletUa" => "user-agent",
        ];
    }
}
