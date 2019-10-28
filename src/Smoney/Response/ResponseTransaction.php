<?php

declare(strict_types=1);

namespace App\Smoney\Response;

use App\ArrayableInterface;
use App\Gateway\TransactionInterface;

class ResponseTransaction implements ArrayableInterface
{
    public function __construct(TransactionInterface $transaction)
    {
    }

    public function toArray(): array
    {
        return [
            'Id' => null,
        ];
    }
}
