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
    public function getResponseInitCreditCard(array $data): ResponseCreditCard
    {
        $transaction = $this->store($this->getFaker()->md5, PaymentType::CREDITCARD, $data);

        return new ResponseCreditCard(
            $transaction->getReference(),
            $transaction->getId(),
            (int) $data['registerCard'] === 1 ? $this->getFaker()->randomNumber() : null
        );
    }

    public function getRequestCreditCardPayment(string $token, int $error = 0): RequestCreditCardPayment
    {
        $transaction = $this->find(null, $token);

        $return = $error === 1 ? $transaction->getData()['errorUrl'] : $transaction->getData()['returnUrl'];

        return new RequestCreditCardPayment($return, $transaction->getId(), $transaction->getReference());
    }

    public function getTransactionDetails(TransactionInterface $transactionDetails): ?ResponseTransactionDetails
    {
        $transaction = $this->find(
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
}
