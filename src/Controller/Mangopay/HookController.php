<?php

declare(strict_types=1);

namespace App\Controller\Mangopay;

use App\Mangopay\Mangopay;
use App\Mangopay\MangopayResolver;
use Symfony\Component\HttpFoundation\Request;

class HookController
{
    public function __invoke(Request $request, Mangopay $gateway, MangopayResolver $resolver)
    {
        // TODO: Implement __invoke() method.
    }
}
