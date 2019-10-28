<?php

declare(strict_types=1);

namespace App\Gateway;

use App\Mangopay\Response\RequestCreateUser;

interface GatewayResolverInterface
{
    public function resolvePrepare(array $data): array;

    public function resolveTransaction(array $data): TransactionInterface;

    public function resolveCheckout(array $data);

    public function resolveUser(array $data): RequestCreateUser;
}
