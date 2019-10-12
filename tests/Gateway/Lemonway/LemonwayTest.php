<?php

declare(strict_types=1);

namespace App\Tests\Gateway\Lemonway;

use App\Entity\Transaction;
use App\Gateway\Lemonway\DTO\ResponseCreditCard;
use App\Gateway\Lemonway\Lemonway;
use App\Gateway\Lemonway\LemonwayResolver;
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

        $lemonway = new Lemonway($repository, new LemonwayResolver());

        $response = $lemonway->getResponseInitCreditCard(new Request([], [
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
        ]));

        static::assertInstanceOf(ResponseCreditCard::class, $response);
        static::assertEquals(new ResponseCreditCard(static::REFERENCE, 1), $response);
    }

    public function testErrorAuthentication(): void
    {
        $repository = $this->createMock(TransactionRepository::class);
        $lemonway = new Lemonway($repository, new LemonwayResolver());

        static::expectException(InvalidOptionsException::class);

        $response = $lemonway->getResponseInitCreditCard(new Request([], [
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
        ]));
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
