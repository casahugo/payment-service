<?php

declare(strict_types=1);

namespace App\Smoney;

use App\Gateway\AbstractGateway;
use App\Gateway\GatewayResolverInterface;

class Smoney extends AbstractGateway
{
    public function resolver(): GatewayResolverInterface
    {
        return new SmoneyResolver();
    }
}
