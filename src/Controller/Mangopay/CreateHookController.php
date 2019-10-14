<?php

declare(strict_types=1);

namespace App\Controller\Mangopay;

use App\Mangopay\Mangopay;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CreateHookController
{
    public function __invoke(Request $request, Mangopay $gateway)
    {
//        $response = $gateway->createHook($request->request->get('Url'), $request->request->get('EventType'));
//
//        return new JsonResponse($response->toArray());
    }
}
