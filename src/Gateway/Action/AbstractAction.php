<?php

declare(strict_types=1);

namespace App\Gateway\Action;

use App\Storage\StorageAwareInterface;
use App\Storage\TraitStorageAware;

abstract class AbstractAction implements ActionInterface, StorageAwareInterface
{
    use TraitStorageAware;
}
