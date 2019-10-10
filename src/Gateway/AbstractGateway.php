<?php
/**
 * @author      Wizacha DevTeam <dev@wizacha.com>
 * @copyright   Copyright (c) Wizacha
 * @license     Proprietary
 */
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