<?php

declare(strict_types=1);

namespace App\Controller\Wallet;

use App\ArrayableInterface;
use App\Gateway\GatewayInterface;
use App\Gateway\Request\User;
use App\Gateway\Request\Wallet;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CreateWalletController
{
    public function __invoke(Request $request, GatewayInterface $gateway)
    {
        if ($request->request->has('Owners')) {
            try {
                /** @var ArrayableInterface $response */
                $response = $gateway->execute(new Wallet(
                    (int) current($request->request->get('Owners')),
                    $request->request->get('Currency', 'EUR'),
                    $request->request->get('Description', 'null')
                ));
            } catch (\Throwable $exception) {
                throw new BadRequestHttpException($exception->getMessage(), $exception);
            }

            return new JsonResponse($response->toArray());
        }

        try {
            /** @var ArrayableInterface $response */
            $response = $gateway->execute(new User(
                null,
                $gateway->resolver()->resolveUser($request->request->all())
            ));
        } catch (\Throwable $exception) {
            throw new BadRequestHttpException($exception->getMessage(), $exception);
        }

        return new JsonResponse($response->toArray());
    }
}
