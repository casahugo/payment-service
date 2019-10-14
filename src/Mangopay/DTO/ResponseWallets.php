<?php

declare(strict_types=1);

namespace App\Mangopay\DTO;

use App\ArrayableInterface;

class ResponseWallets implements ArrayableInterface
{
    /** @var array  */
    private $wallets;

    public function __construct(array $wallets)
    {
        $this->wallets = $wallets;
    }

    public function toArray(): array
    {
        return array_map(function (ArrayableInterface $wallet): array {
            return $wallet->toArray();
        }, $this->wallets);
    }
}
