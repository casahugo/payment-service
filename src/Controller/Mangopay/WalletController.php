<?php

declare(strict_types=1);

namespace App\Controller\Mangopay;

use App\Mangopay\Mangopay;
use Symfony\Component\HttpFoundation\JsonResponse;

class WalletController
{
    public function __invoke(int $id, Mangopay $gateway)
    {
        $user = $gateway->getUser($id);

        return new JsonResponse($user->toArray());
    }
}
