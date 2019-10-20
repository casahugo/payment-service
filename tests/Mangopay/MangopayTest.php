<?php

declare(strict_types=1);

namespace App\Tests\Mangopay;

use App\Entity\Transaction;
use App\Gateway\Request\Capture;
use App\Gateway\Request\Prepare;
use App\Mangopay\Action\CaptureAction;
use App\Mangopay\Action\PrepareAction;
use App\Mangopay\Action\TransactionAction;
use App\Mangopay\Mangopay;
use App\Mangopay\Response\ResponseCapture;
use App\Mangopay\Response\ResponsePrepare;
use App\Mangopay\Response\ResponseTransaction;
use App\Storage\Storage;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

class MangopayTest extends TestCase
{
    public function testPrepareCreditCard(): void
    {
        $storage = $this->createMock(Storage::class);
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

    public function testGetRequestCreditCardPayment(): void
    {
        $excepted = [
            'RedirectUrl' => 'http://www.return-site.com/returnURL/',
            'ReturnURL' => 'http://www.return-site.com/returnURL/',
        ];

        $storage = $this->createMock(Storage::class);
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

    public function testGetTransactionDetails(): void
    {
        $storage = $this->createMock(Storage::class);
        $storage->method('findTransaction')->willReturn(
            (new Transaction())->setId(1)->setData([])
        );

        $gateway = new Mangopay([new TransactionAction()], $storage, $this->createMock(RouterInterface::class));
        $transaction = $gateway->execute(new \App\Gateway\Request\Transaction(
            $gateway->resolver()->resolveTransaction(['id' => 1])
        ));

        static::assertInstanceOf(ResponseTransaction::class, $transaction);
    }
}
