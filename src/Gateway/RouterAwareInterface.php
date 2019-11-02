<?php

declare(strict_types=1);

namespace App\Gateway;

interface RouterAwareInterface
{
    public function setRouter($router);
}
