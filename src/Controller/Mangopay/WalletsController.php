<?php

declare(strict_types=1);

namespace App\Controller\Mangopay;

use App\Mangopay\Mangopay;
use Symfony\Component\HttpFoundation\JsonResponse;

class WalletsController
{
    public function __invoke(int $userId, Mangopay $gateway)
    {
        $wallets = $gateway->getUserWallet($userId);

        return new JsonResponse($wallets->toArray());
    }
}
