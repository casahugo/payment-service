<?php

declare(strict_types=1);

namespace App\Mangopay\DTO;

use App\Gateway\TransactionInterface;

class RequestTransactionDetails implements TransactionInterface
{
    /** @var mixed|null  */
    private $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return null;
    }
}
