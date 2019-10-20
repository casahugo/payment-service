<?php

declare(strict_types=1);

namespace App\Controller\Wallet;

use App\ArrayableInterface;
use App\Gateway\GatewayInterface;
use App\Gateway\Request\Wallet;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class WalletsController
{
    public function __invoke(int $userId, GatewayInterface $gateway)
    {
        try {
            /** @var ArrayableInterface $response */
            $response = $gateway->execute(new Wallet($userId));
        } catch (\Throwable $exception) {
            throw new BadRequestHttpException($exception->getMessage(), $exception);
        }

        return new JsonResponse($response->toArray());
    }
}
