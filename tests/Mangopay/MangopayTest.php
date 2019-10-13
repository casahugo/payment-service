<?php

declare(strict_types=1);

namespace App\Tests\Mangopay;

use App\Entity\Transaction;
use App\Mangopay\DTO\RequestCreditCardPayment;
use App\Mangopay\DTO\RequestTransactionDetails;
use App\Mangopay\DTO\ResponseCreditCard;
use App\Mangopay\DTO\ResponseTransactionDetails;
use App\Mangopay\Mangopay;
use App\Mangopay\MangopayResolver;
use App\Repository\TransactionRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class MangopayTest extends TestCase
{
    public function testPrepareCreditCard(): void
    {
        $repository = $this->createMock(TransactionRepository::class);
        $repository->method('save')->willReturnCallback(function (Transaction $transaction) {
            return $transaction->setId(1);
        });

        $gateway = new Mangopay($repository);

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

        $response = $gateway->prepareCreditCard(
            (new MangopayResolver())->resolveCreditCard((new Request([], $data))->request->all())
        );

        static::assertInstanceOf(ResponseCreditCard::class, $response);
        static::assertEquals(new ResponseCreditCard(1, $data), $response);
    }

    public function testGetRequestCreditCardPayment(): void
    {
        $excepted = [
            'RedirectUrl' => 'http://www.redirect-site.com/returnURL/',
            'ReturnURL' => 'http://www.return-site.com/returnURL/',
        ];

        $repository = $this->createMock(TransactionRepository::class);
        $repository->method('findOneBy')->willReturn(
            (new Transaction())->setId(1)->setData($excepted)
        );

        $gateway = new Mangopay($repository);

        $response = $gateway->getRequestCreditCardPayment('1', 0);

        static::assertInstanceOf(RequestCreditCardPayment::class, $response);
        static::assertEquals(
            new RequestCreditCardPayment($excepted['RedirectUrl'], $excepted['ReturnURL'], 1),
            $response
        );
    }

    public function testGetTransactionDetails(): void
    {
        $repository = $this->createMock(TransactionRepository::class);
        $repository->method('findOneBy')->willReturn(
            (new Transaction())->setId(1)->setData([])
        );

        $gateway = new Mangopay($repository);
        $transaction = $gateway->getTransactionDetails(new RequestTransactionDetails(['Id' => '1']));

        static::assertInstanceOf(ResponseTransactionDetails::class, $transaction);
    }
}