<?php

declare(strict_types=1);

namespace App\Gateway;

use Symfony\Component\Routing\RouterInterface;

trait TraitRouterAware
{
    /** @var RouterInterface  */
    private $router;

    public function setRouter(RouterInterface $router)
    {
        $this->router = $router;
    }
}
