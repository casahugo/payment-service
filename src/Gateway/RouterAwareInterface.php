<?php

declare(strict_types=1);

namespace App\Gateway;

use Symfony\Component\Routing\RouterInterface;

interface RouterAwareInterface
{
    public function setRouter(RouterInterface $router);
}
