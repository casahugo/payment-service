<?php

declare(strict_types=1);

namespace App\Tests\Lemonway;

use App\Entity\Transaction;
use App\Lemonway\DTO\ResponseCreditCard;
use App\Lemonway\Lemonway;
use App\Lemonway\LemonwayResolver;
use App\Repository\TransactionRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;

class LemonwayTest extends TestCase
{
    private const REFERENCE = '72306889c68dfe6d8e3e65f02b4e33ae';

    public function testValidGetResponseCreditCard(): void
    {
        $repository = $this->createMock(TransactionRepository::class);
        $repository->method('save')->willReturnCallback(function (Transaction $transaction) {
            $transaction->setId(1);
            $transaction->setReference(static::REFERENCE);

            return $transaction;
        });

        $lemonway = new Lemonway($repository);

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

        $response = $lemonway->prepareCreditCard(
            (new LemonwayResolver())->resolveCreditCard($request->request->get('p'))
        );

        static::assertInstanceOf(ResponseCreditCard::class, $response);
        static::assertEquals(new ResponseCreditCard(static::REFERENCE, 1), $response);
    }

    public function testErrorAuthentication(): void
    {
        $repository = $this->createMock(TransactionRepository::class);
        $lemonway = new Lemonway($repository);

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

        $response = $lemonway->prepareCreditCard(
            (new LemonwayResolver())->resolveCreditCard($request->request->get('p'))
        );
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
