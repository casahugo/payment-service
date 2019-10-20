<?php

declare(strict_types=1);

namespace App\Gateway;

interface GatewayInterface
{
    public function execute($request);

    public function resolver(): GatewayResolverInterface;
}
