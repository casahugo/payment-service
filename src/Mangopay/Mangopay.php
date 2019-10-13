<?php

declare(strict_types=1);

namespace App\Mangopay;

use App\Enum\PaymentType;
use App\Gateway\AbstractGateway;
use App\Gateway\GatewayInterface;
use App\Gateway\TransactionInterface;
use App\Mangopay\DTO\RequestCreditCardPayment;
use App\Mangopay\DTO\ResponseCreditCard;
use App\Mangopay\DTO\ResponseTransactionDetails;

class Mangopay extends AbstractGateway implements GatewayInterface
{
    public function prepareCreditCard(array $data)
    {
        $transaction = $this->store($this->getFaker()->md5, PaymentType::CREDITCARD, $data);

        return new ResponseCreditCard($transaction->getId(), $data);
    }

    public function getRequestCreditCardPayment(string $token, int $error = 0)
    {
        $transaction = $this->find((int) $token);

        return new RequestCreditCardPayment(
            $transaction->getData()['RedirectUrl'],
            $transaction->getData()['ReturnURL'],
            $transaction->getId()
        );
    }

    public function getTransactionDetails(TransactionInterface $transactionDetails)
    {
        $transaction = $this->find($transactionDetails->getId());

        return new ResponseTransactionDetails($transaction->getId(), $transaction->getData());
    }
}
