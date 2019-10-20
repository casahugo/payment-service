<?php

declare(strict_types=1);

namespace App\Controller\Hook;

use App\Mangopay\Mangopay;
use Symfony\Component\HttpFoundation\Request;

class CreateHookController
{
    public function __invoke(Request $request, string $gatewayName, Mangopay $gateway)
    {
    }
}
