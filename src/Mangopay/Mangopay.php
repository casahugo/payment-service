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
        $transaction = $this->getStorage()->saveTransaction($this->getFaker()->md5, PaymentType::CREDITCARD, $data);

        return new ResponseCreditCard($transaction->getId(), $data);
    }

    public function getRequestCreditCardPayment(string $token, int $error = 0)
    {
        $transaction = $this->getStorage()->findTransaction((int) $token);

        return new RequestCreditCardPayment(
            $transaction->getData()['RedirectUrl'],
            $transaction->getData()['ReturnURL'],
            $transaction->getId()
        );
    }

    public function getTransactionDetails(TransactionInterface $transactionDetails)
    {
        $transaction = $this->getStorage()->findTransaction($transactionDetails->getId());

        return new ResponseTransactionDetails($transaction->getId(), $transaction->getData());
    }

    public function getHook(string $id)
    {
        // TODO: Implement getHook() method.
    }

    public function createHook(string $id)
    {
        // TODO: Implement createHook() method.
    }

    public function getUser(string $id)
    {
        // TODO: Implement getUser() method.
    }

    public function createUser($user, $wallet)
    {
        // TODO: Implement createUser() method.
    }
}
