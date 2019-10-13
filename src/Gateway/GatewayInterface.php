<?php

declare(strict_types=1);

namespace App\Gateway;

interface GatewayInterface
{
    public function prepareCreditCard(array $data);

    public function getRequestCreditCardPayment(string $token, int $error = 0);

    public function getTransactionDetails(TransactionInterface $transactionDetails);

    public function getHook(string $id);

    public function createHook(string $id);

    public function getUser(string $id);

    public function createUser($user, $wallet);
}
