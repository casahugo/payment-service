<?php

declare(strict_types=1);

namespace App\Gateway;

interface TransactionInterface
{
    public function getId(): ?int;

    public function getReference(): ?string;
}
