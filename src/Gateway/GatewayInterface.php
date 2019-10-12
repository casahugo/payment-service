<?php

declare(strict_types=1);

namespace App\Gateway;

use Symfony\Component\HttpFoundation\Request;

interface GatewayInterface
{
    public function getResponseInitCreditCard(Request $request);

    public function getResponseCreditCardPayment(string $token, int $erreur = 0);

    public function getTransactionDetails(Request $request);

    public function verifyToken(string $token);
}
