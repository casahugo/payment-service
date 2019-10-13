<?php

declare(strict_types=1);

namespace App\Gateway;

use App\Storage;
use Faker\Factory;
use Faker\Generator;

abstract class AbstractGateway
{
    /** @var Storage  */
    private $storage;

    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }

    public function getStorage(): Storage
    {
        return $this->storage;
    }

    public function getFaker(): Generator
    {
        return Factory::create();
    }
}
