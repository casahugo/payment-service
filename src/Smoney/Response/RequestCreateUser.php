<?php

declare(strict_types=1);

namespace App\Smoney\Response;

use App\ArrayableInterface;
use App\Gateway\UserInterface;

class RequestCreateUser implements ArrayableInterface, UserInterface
{
    /** @var array  */
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getId(): ?int
    {
        return (int) str_replace('company-', '', $this->data['AppUserId'] ?? null);
    }

    public function getEmail(): string
    {
        return $this->data['Profile']['Email'];
    }

    public function getFirstname(): string
    {
        return $this->data['Profile']['Firstname'];
    }

    public function getLastname(): string
    {
        return $this->data['Profile']['Lastname'];
    }

    public function toArray(): array
    {
        return [
            'AppUserId' => 'company-' . $this->getId(),
        ];
    }
}
