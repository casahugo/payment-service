<?php

declare(strict_types=1);

namespace App\Gateway\Request;

use App\ArrayableInterface;

abstract class Generic implements ArrayableInterface
{
    /** @var mixed  */
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function toArray(): array
    {
        return $this->data;
    }
}
