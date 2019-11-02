<?php

declare(strict_types=1);

namespace App\Gateway\Request;

use App\Gateway\TransactionInterface;

class Checkout
{
    /** @var int|string  */
    private $id;

    /** @var TransactionInterface */
    private $transaction;

    public function __construct($identifier)
    {
        $this->id = $identifier;
    }

    public function getId(): ?int
    {
        return \is_int($this->id) ? $this->id : null;
    }

    public function getReference(): ?string
    {
        return \is_string($this->id) ? $this->id : null;
    }

    public function getTransaction(): ?TransactionInterface
    {
        return $this->transaction;
    }

    public function setTransaction(TransactionInterface $transaction): self
    {
        $this->transaction = $transaction;

        return $this;
    }
}
