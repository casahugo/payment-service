<?php

declare(strict_types=1);

namespace App\Gateway\Request;

class Capture
{
    /** @var string  */
    private $token;

    /** @var bool  */
    private $errors;

    public function __construct(string $token = null, bool $errors = false)
    {
        $this->token = $token;
        $this->errors = $errors;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function hasErrors(): bool
    {
        return $this->errors;
    }
}
