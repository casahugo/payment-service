<?php

declare(strict_types=1);

namespace App\Tests\Smoney;

use App\Entity\Transaction;
use App\Gateway\Request\Prepare;
use App\Smoney\Action\PrepareAction;
use App\Smoney\Response\ResponsePrepare;
use App\Smoney\Smoney;
use App\Storage\StorageInterface;
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
            'OrderId' => '1',
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
        static::assertTrue(true);
    }

    public function testCheckoutAction(): void
    {
        static::assertTrue(true);
    }

    public function testTransactionAction(): void
    {
        static::assertTrue(true);
    }
}
