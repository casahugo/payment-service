<?php

declare(strict_types=1);

namespace App\Gateway;

use Symfony\Component\Routing\RouterInterface;

trait TraitRouterAware
{
    /** @var RouterInterface  */
    protected $router;

    public function setRouter($router)
    {
        $this->router = $router;
    }
}
