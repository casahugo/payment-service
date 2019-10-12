<?php

declare(strict_types=1);

namespace App\Controller\Lemonway;

use App\Gateway\Lemonway\Lemonway;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GetMoneyInTransDetailsController
{
    /** @var Lemonway  */
    private $lemonway;

    public function __construct(Lemonway $lemonway)
    {
        $this->lemonway = $lemonway;
    }

    public function __invoke(Request $request): Response
    {
        try {
            $response = $this->lemonway->getTransactionDetails($request);
        } catch (\Throwable $exception) {
            if (preg_match('/(wlLogin|wlPass)/', $exception->getMessage())) {
                throw new AccessDeniedHttpException($exception->getMessage(), $exception);
            }

            throw new BadRequestHttpException($exception->getMessage(), $exception);
        }

        if (is_null($response)) {
            throw new NotFoundHttpException('Non-existent transaction');
        }

        return new JsonResponse($response->toArray());
    }
}
