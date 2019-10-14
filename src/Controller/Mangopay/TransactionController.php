<?php

declare(strict_types=1);

namespace App\Controller\Mangopay;

use App\Mangopay\Mangopay;
use App\Mangopay\MangopayResolver;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TransactionController
{
    public function __invoke(int $id, Mangopay $gateway, MangopayResolver $resolver): Response
    {
        try {
            $response = $gateway->getTransactionDetails(
                $resolver->resolveTransactionDetails($id)
            );
        } catch (\Throwable $exception) {
            throw new BadRequestHttpException($exception->getMessage(), $exception);
        }

        if (is_null($response)) {
            throw new NotFoundHttpException('Non-existent transaction');
        }

        return new JsonResponse($response->toArray());
    }
}
