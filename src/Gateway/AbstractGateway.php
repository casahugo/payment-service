<?php

declare(strict_types=1);

namespace App\Gateway;

use App\Storage;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\Routing\RouterInterface;

abstract class AbstractGateway
{
    /** @var Storage  */
    private $storage;

    /** @var RouterInterface  */
    private $router;

    public function __construct(Storage $storage, RouterInterface $router)
    {
        $this->storage = $storage;
        $this->router = $router;
    }

    public function getStorage(): Storage
    {
        return $this->storage;
    }

    public function getRouter(): RouterInterface
    {
        return $this->router;
    }

    public function getFaker(): Generator
    {
        return Factory::create();
    }
}
