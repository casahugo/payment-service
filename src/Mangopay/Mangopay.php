<?php

declare(strict_types=1);

namespace App\Mangopay;

use App\Gateway\AbstractGateway;
use App\Gateway\GatewayResolverInterface;

class Mangopay extends AbstractGateway
{
    public function resolver(): GatewayResolverInterface
    {
        return new MangopayResolver();
    }
}
