<?php

declare(strict_types=1);

namespace App\Controller\Mangopay;

use App\Mangopay\DTO\ResponseHook;
use App\Mangopay\Mangopay;
use Symfony\Component\HttpFoundation\Request;

class UpdateHookController
{
    public function __invoke(int $hookId, Request $request, Mangopay $gateway)
    {
        $hook = $gateway->getStorage()->updateHook(
            $hookId,
            $request->request->get('Url'),
            $request->request->get('Status')
        );

        return new ResponseHook($hook);
    }
}
