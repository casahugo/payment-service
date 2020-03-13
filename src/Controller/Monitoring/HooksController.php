<?php

declare(strict_types=1);

namespace App\Controller\Monitoring;

use App\Entity\Hook;
use App\Storage\StorageInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class HooksController
{
    public function __invoke(StorageInterface $storage): JsonResponse
    {
        return new JsonResponse([
            'items' => \array_map(function (Hook $transaction): array {
                return $transaction->toArray();
            }, $storage->findHooks())
        ]);
    }
}
