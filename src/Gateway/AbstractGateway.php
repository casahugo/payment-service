<?php

declare(strict_types=1);

namespace App\Gateway;

use Faker\Factory;

abstract class AbstractGateway
{
    public function getFaker()
    {
        return Factory::create();
    }
}
