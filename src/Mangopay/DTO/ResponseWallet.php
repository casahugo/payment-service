<?php

declare(strict_types=1);

namespace App\Mangopay\DTO;

use App\ArrayableInterface;
use App\Entity\Wallet;

class ResponseWallet implements ArrayableInterface
{
    /** @var Wallet  */
    private $wallet;

    public function __construct(Wallet $wallet)
    {
        $this->wallet = $wallet;
    }

    public function toArray(): array
    {
        return [
            'Description' => $this->wallet->getDescription(),
            'Owners' => [$this->wallet->getUserId()],
            'Balance' => [
                'Currency' => 'EUR',
                'Amount' => '873910',
            ],
            'Currency' => $this->wallet->getCurrency(),
            'FundsType' => 'DEFAULT',
            'Id' => $this->wallet->getId(),
            'Tag' => 'custom meta',
            'CreationDate' => '1442183159',
        ];
    }
}
