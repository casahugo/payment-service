<?php

declare(strict_types=1);

namespace App\Gateway;

interface GatewayResolverInterface
{
    public function resolvePrepare(array $data): array;

    public function resolveTransaction(array $data): TransactionInterface;

    public function resolveCheckout(array $data);

    public function resolveWallet(array $data);

    public function resolveUser(array $data): UserInterface;
}
