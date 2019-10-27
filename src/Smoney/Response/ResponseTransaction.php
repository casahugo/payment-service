<?php

declare(strict_types=1);

namespace App\Smoney\Response;

use App\ArrayableInterface;

class ResponseTransaction implements ArrayableInterface
{

    public function toArray(): array
    {
        return [
            'Id' => null,
        ];
    }
}
