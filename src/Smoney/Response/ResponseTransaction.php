<?php

declare(strict_types=1);

namespace App\Smoney\Response;

use App\ArrayableInterface;
use App\Gateway\TransactionInterface;

class ResponseTransaction implements ArrayableInterface
{
    /** @var TransactionInterface  */
    private $transaction;

    public function __construct(TransactionInterface $transaction)
    {
        $this->transaction = $transaction;
    }

    public function toArray(): array
    {
        return [
            'Id' => $this->transaction->getId(),
            'Status' => 1,
        ];
    }
}
