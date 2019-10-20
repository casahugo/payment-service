<?php

declare(strict_types=1);

namespace App\Tests\Lemonway;

use App\Entity\Transaction;
use App\Gateway\Request\Prepare;
use App\Lemonway\Action\PrepareAction;
use App\Lemonway\Lemonway;
use App\Lemonway\Response\ResponsePrepare;
use App\Storage\Storage;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;
use Symfony\Component\Routing\RouterInterface;

class LemonwayTest extends TestCase
{
    private const REFERENCE = '72306889c68dfe6d8e3e65f02b4e33ae';

    public function testValidGetResponseCreditCard(): void
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
