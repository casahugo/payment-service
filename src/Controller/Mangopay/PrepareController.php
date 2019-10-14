<?php

declare(strict_types=1);

namespace App\Controller\Mangopay;

use App\Mangopay\Mangopay;
use App\Mangopay\MangopayResolver;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class PrepareController
{
    public function __invoke(Request $request, Mangopay $gateway, MangopayResolver $resolver): Response
    {
        try {
            $response = $gateway->prepareCreditCard(
                $resolver->resolveCreditCard($request->request->all())
            );
        } catch (\Throwable $exception) {
            throw new BadRequestHttpException($exception->getMessage(), $exception);
        }

        return new JsonResponse($response->toArray());
    }
}
