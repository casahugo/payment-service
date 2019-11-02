<?php

declare(strict_types=1);

namespace App\Gateway;

interface UserInterface
{
    public function getId(): ?int;

    public function getEmail(): string;

    public function getFirstname(): string;

    public function getLastname(): string;
}
