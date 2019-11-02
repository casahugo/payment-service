<?php

declare(strict_types=1);

namespace App\Smoney\Response;

use App\ArrayableInterface;
use App\Gateway\UserInterface;

class ResponseUser implements ArrayableInterface
{
    /** @var null|UserInterface  */
    private $user;

    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }

    public function toArray(): array
    {
        return [
            'AppUserId' => 'company-' . $this->user->getId(),
        ];
    }
}
