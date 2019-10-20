<?php

declare(strict_types=1);

namespace App\Storage;

trait TraitStorageAware
{
    /** @var Storage  */
    protected $storage;

    public function setStorage(Storage $storage)
    {
        $this->storage = $storage;

        return $this;
    }
}
