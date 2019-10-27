<?php

declare(strict_types=1);

namespace App\Storage;

trait TraitStorageAware
{
    /** @var StorageInterface  */
    protected $storage;

    public function setStorage(StorageInterface $storage)
    {
        $this->storage = $storage;

        return $this;
    }
}
