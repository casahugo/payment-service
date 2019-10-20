<?php

declare(strict_types=1);

namespace App\Gateway\Request;

use App\Gateway\UserInterface;

class User
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

    public function getData(): ?UserInterface
    {
        return $this->data;
    }

    public function getEmail(): ?string
    {
        if ($this->data instanceof UserInterface) {
            return $this->data->getEmail();
        }
    }

    public function getFirstname(): ?string
    {
        if ($this->data instanceof UserInterface) {
            return $this->data->getFirstname();
        }
    }

    public function getLastname(): ?string
    {
        if ($this->data instanceof UserInterface) {
            return $this->data->getLastname();
        }
    }
}
