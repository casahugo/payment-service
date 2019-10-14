<?php

declare(strict_types=1);

namespace App\Gateway;

interface GatewayInterface
{
    public function prepareCreditCard(array $data);

    public function getRequestCreditCardPayment(string $token, int $error = 0);

    public function getTransactionDetails(TransactionInterface $transactionDetails);

    public function getUser(int $id);

    public function createUser(UserInterface $user);
}
