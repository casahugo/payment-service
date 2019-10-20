<?php

declare(strict_types=1);

namespace App\Lemonway;

use App\Gateway\AbstractGateway;
use App\Gateway\GatewayResolverInterface;

final class Lemonway extends AbstractGateway
{
    public function resolver(): GatewayResolverInterface
    {
        return new LemonwayResolver();
    }
}
