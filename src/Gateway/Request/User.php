<?php

declare(strict_types=1);

namespace App\Gateway\Request;

use App\Gateway\UserInterface;

class User implements UserInterface
{
    /** @var int|null  */
    private $id;

    /** @var UserInterface  */
    private $data;

    public function __construct(?int $id, UserInterface $data = null)
    {
        $this->id = $id;
        $this->data = $data;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function hasId(): bool
    {
        return false === is_null($this->id);
    }

    public function getEmail(): string
    {
        if ($this->data instanceof UserInterface) {
            return $this->data->getEmail();
        }

        return '';
    }

    public function getFirstname(): string
    {
        if ($this->data instanceof UserInterface) {
            return $this->data->getFirstname();
        }

        return '';
    }

    public function getLastname(): string
    {
        if ($this->data instanceof UserInterface) {
            return $this->data->getLastname();
        }

        return '';
    }
}
