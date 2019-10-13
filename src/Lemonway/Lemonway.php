<?php

declare(strict_types=1);

namespace App\Lemonway;

use App\Enum\PaymentType;
use App\Gateway\AbstractGateway;
use App\Gateway\GatewayInterface;
use App\Gateway\TransactionInterface;
use App\Lemonway\DTO\ResponseCreditCard;
use App\Lemonway\DTO\RequestCreditCardPayment;
use App\Lemonway\DTO\ResponseTransactionDetails;

final class Lemonway extends AbstractGateway implements GatewayInterface
{
    public function prepareCreditCard(array $data): ResponseCreditCard
    {
        $transaction = $this->getStorage()->saveTransaction(
            $this->getFaker()->md5,
            PaymentType::CREDITCARD,
            $data
        );

        return new ResponseCreditCard(
            $transaction->getReference(),
            $transaction->getId(),
            (int) $data['registerCard'] === 1 ? $this->getFaker()->randomNumber() : null
        );
    }

    public function getRequestCreditCardPayment(string $token, int $error = 0): RequestCreditCardPayment
    {
        $transaction = $this->getStorage()->findTransaction(null, $token);

        $return = $error === 1 ? $transaction->getData()['errorUrl'] : $transaction->getData()['returnUrl'];

        return new RequestCreditCardPayment($return, $transaction->getId(), $transaction->getReference());
    }

    public function getTransactionDetails(TransactionInterface $transactionDetails): ?ResponseTransactionDetails
    {
        $transaction = $this->getStorage()->findTransaction(
            $transactionDetails->getId(),
            $transactionDetails->getReference()
        );

        $data = $transaction->getData();

        return new ResponseTransactionDetails(
            $transaction->getId(),
            $data['wallet'],
            (float) $data['amountTot'],
            $data['comment']
        );
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
