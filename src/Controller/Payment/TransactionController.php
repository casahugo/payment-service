<?php

declare(strict_types=1);

namespace App\Controller\Payment;

use App\ArrayableInterface;
use App\Gateway\GatewayInterface;
use App\Gateway\Request\Transaction;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TransactionController
{
    public function __invoke(Request $request, GatewayInterface $gateway): Response
    {
        $data = array_merge(
            $request->request->all(),
            $request->query->all(),
            $request->attributes->all()
        );

        try {
            /** @var ArrayableInterface $response */
            $response = $gateway->execute(new Transaction(
                $gateway->resolver()->resolveTransaction($data)
            ));
        } catch (\Throwable $exception) {
            throw new BadRequestHttpException($exception->getMessage(), $exception);
        }

        if (false == $response instanceof ArrayableInterface) {
            throw new NotFoundHttpException('Transaction not found.');
        }

        return new JsonResponse($response->toArray());
    }
}
