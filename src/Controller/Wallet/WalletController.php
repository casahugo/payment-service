<?php

declare(strict_types=1);

namespace App\Controller\Wallet;

use App\ArrayableInterface;
use App\Gateway\GatewayInterface;
use App\Gateway\Request\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class WalletController
{
    public function __invoke(int $id, GatewayInterface $gateway)
    {
        try {
            /** @var ArrayableInterface $response */
            $response = $gateway->execute(new User($id));
        } catch (\Throwable $exception) {
            throw new BadRequestHttpException($exception->getMessage(), $exception);
        }

        return new JsonResponse($response->toArray());
    }
}
