<?php

declare(strict_types=1);

namespace App\Storage;

interface StorageAwareInterface
{
    public function setStorage(Storage $storage);
}
