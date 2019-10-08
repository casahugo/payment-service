<?php
/**
 * @author      Wizacha DevTeam <dev@wizacha.com>
 * @copyright   Copyright (c) Wizacha
 * @license     Proprietary
 */
declare(strict_types=1);

namespace App\Tests\Lemonway;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TestCreditCard extends WebTestCase
{
    public function testCreateCreditCard(): void
    {
        /** @var Client $client */
        $client = static::createClient();
        $client->enableProfiler();
        $client->request('POST', '/toto');


        static::assertTrue(true);
    }
}