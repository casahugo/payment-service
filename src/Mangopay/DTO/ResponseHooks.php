<?php

declare(strict_types=1);

namespace App\Mangopay\DTO;

use App\ArrayableInterface;

class ResponseHooks implements ArrayableInterface
{
    /** @var array  */
    private $hooks;

    public function __construct(array $hooks)
    {
        $this->hooks = $hooks;
    }

    public function toArray(): array
    {
        return array_map(function (ArrayableInterface $hook) {
            return $hook->toArray();
        }, $this->hooks);
    }
}
