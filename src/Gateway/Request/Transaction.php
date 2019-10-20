<?php

declare(strict_types=1);

namespace App\Gateway\Request;

use App\Gateway\TransactionInterface;

class Transaction
{
    /** @var TransactionInterface  */
    private $request;

    public function __construct(TransactionInterface $request)
    {
        $this->request = $request;
    }

    public function getId(): ?int
    {
        return $this->request->getId();
    }

    public function getReference(): ?string
    {
        return $this->request->getReference();
    }
}
