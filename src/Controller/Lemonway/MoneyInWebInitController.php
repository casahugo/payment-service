<?php

declare(strict_types=1);

namespace App\Controller\Lemonway;

use App\Gateway\Lemonway\Lemonway;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class MoneyInWebInitController
{
    public function __invoke(Request $request, Lemonway $lemonway): Response
    {
        try {
            $response = $lemonway->getResponseInitCreditCard($request);
        } catch (\Throwable $exception) {
            if (preg_match('/(wlLogin|wlPass)/', $exception->getMessage())) {
                throw new AccessDeniedHttpException($exception->getMessage(), $exception);
            }

            throw new BadRequestHttpException($exception->getMessage(), $exception);
        }

        return new JsonResponse($response->toArray());
    }
}
