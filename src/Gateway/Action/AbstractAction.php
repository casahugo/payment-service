<?php

declare(strict_types=1);

namespace App\Gateway\Action;

use App\Gateway\RouterAwareInterface;
use App\Gateway\TraitRouterAware;
use App\Storage\StorageAwareInterface;
use App\Storage\TraitStorageAware;

abstract class AbstractAction implements ActionInterface, StorageAwareInterface, RouterAwareInterface
{
    use TraitStorageAware;
    use TraitRouterAware;
}
