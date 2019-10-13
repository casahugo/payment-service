<?php

declare(strict_types=1);

namespace App\Lemonway\DTO;

use App\Gateway\TransactionInterface;

class RequestTransactionDetails implements TransactionInterface
{
    /** @var int|null  */
    private $id;

    /** @var string|null  */
    private $reference;

    /** @var string|null  */
    private $comment;

    /** @var string|null  */
    private $startDate;

    /** @var string|null  */
    private $endDate;

    public function __construct(array $data)
    {
        $this->id = $data['transactionId'] ?? null;
        $this->reference = $data['transactionMerchantToken'] ?? null;
        $this->comment = $data['transactionComment'] ?? null;
        $this->startDate = $data['startDate'] ?? null;
        $this->endDate = $data['endDate'] ?? null;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function getStartDate(): ?string
    {
        return $this->startDate;
    }

    public function getEndDate(): ?string
    {
        return $this->endDate;
    }
}
