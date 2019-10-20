<?php

declare(strict_types=1);

namespace App\Controller\Payment;

use App\ArrayableInterface;
use App\Gateway\GatewayInterface;
use App\Gateway\Request\Prepare;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class PrepareController
{
    public function __invoke(Request $request, GatewayInterface $gateway): Response
    {
        try {
            /** @var ArrayableInterface $response */
            $response = $gateway->execute(
                new Prepare($gateway->resolver()->resolvePrepare($request->request->all()))
            );
        } catch (\Throwable $exception) {
            throw new BadRequestHttpException($exception->getMessage(), $exception);
        }

        return new JsonResponse($response->toArray());
    }
}
