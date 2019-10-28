<?php

declare(strict_types=1);

namespace App\Gateway\Request;

use App\Gateway\TransactionInterface;

class Capture
{
    /** @var int  */
    private $transactionId;

    /** @var bool  */
    private $errors;

    /** @var TransactionInterface */
    private $transaction;

    public function __construct(int $transactionId, bool $errors = false)
    {
        $this->transactionId = $transactionId;
        $this->errors = $errors;
    }

    public function getId(): int
    {
        return $this->transactionId;
    }

    public function getReference(): ?string
    {
        return null;
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

    public function hasErrors(): bool
    {
        return $this->errors;
    }
}
