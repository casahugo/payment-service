<?php

declare(strict_types=1);

namespace App\Gateway\Request;

class Wallet
{
    /** @var int  */
    private $userId;

    /** @var string|null  */
    private $currency;

    /** @var string|null  */
    private $description;

    public function __construct(int $userId, ?string $currency = null, string $description = null)
    {
        $this->userId = $userId;
        $this->currency = $currency;
        $this->description = $description;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
}
