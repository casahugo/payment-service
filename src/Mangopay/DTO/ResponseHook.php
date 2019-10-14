<?php

declare(strict_types=1);

namespace App\Mangopay\DTO;

use App\ArrayableInterface;
use App\Entity\Hook;

class ResponseHook implements ArrayableInterface
{
    /** @var Hook  */
    private $hook;

    public function __construct(Hook $hook)
    {
        $this->hook = $hook;
    }

    public function toArray(): array
    {
        return [
            'Url' => $this->hook->getUrl(),
            'Status' => $this->hook->getStatus(),
            'Validity' => 'VALID',
            'EventType' => $this->hook->getEvent(),
            'Id' => $this->hook->getId(),
            'Tag' => 'custom meta',
            'CreationDate' => '1463495435',
        ];
    }
}
