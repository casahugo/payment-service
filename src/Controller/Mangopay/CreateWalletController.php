<?php

declare(strict_types=1);

namespace App\Controller\Mangopay;

use App\Mangopay\Mangopay;
use App\Mangopay\MangopayResolver;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CreateWalletController
{
    public function __invoke(Request $request, Mangopay $gateway, MangopayResolver $resolver)
    {
        if ($request->request->has('Owners')) {
            try {
                $response = $gateway->createUserWallet(
                    (int) current($request->request->get('Owners')),
                    $request->request->get('Currency', 'EUR'),
                    $request->request->get('Description', 'null')
                );
            } catch (\Throwable $exception) {
                throw new BadRequestHttpException($exception->getMessage(), $exception);
            }

            return new JsonResponse($response->toArray());
        }

        try {
            $response = $gateway->createUser($resolver->resolveUser($request->request->all()));
        } catch (\Throwable $exception) {
            throw new BadRequestHttpException($exception->getMessage(), $exception);
        }

        return new JsonResponse($response->toArray());
    }
}
