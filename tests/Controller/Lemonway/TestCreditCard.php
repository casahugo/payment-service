<?php
/**
 * @author      Wizacha DevTeam <dev@wizacha.com>
 * @copyright   Copyright (c) Wizacha
 * @license     Proprietary
 */
declare(strict_types=1);

namespace App\Tests\Lemonway;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TestCreditCard extends WebTestCase
{
    private const DIRECTKIT = '/api/v1/lemonway/';

    public function testInitCreditCard(): void
    {
        $client = static::createClient();
        $client->enableProfiler();

        $crawler = $client->request(
            'POST',
            static::DIRECTKIT . 'MoneyInWebInit',
            array_merge($this->buildRequest(), [
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
        );

        static::assertTrue(true);
    }

    /** @return string[] */
    private function buildRequest(): array
    {
        return [
            "wlPass" => "password",
            "wlLogin" => "login",
            "language" => "lang",
            "version" => "version",
            "walletIp" => "127.0.0.1",
            "walletUa" => "user-agent",
        ];
    }

    public function buildResponseError(): array
    {
        return [
            'E' => [
                'Error' => 'Non utilisé dans le kit MARQUE BLANCHE',
                'Code' => 120,
                'Msg' => 'message erreur',
                'Prio' => "Non utilisé dans le kit MARQUE BLANCHE",
                'INT_MSG' => '05-00-51',
            ]
        ];
    }
}