<?php

declare(strict_types=1);

namespace App\Controller\Monitoring;

use App\Entity\Transaction;
use App\Storage\StorageInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class TransactionsController
{
    public function __invoke(StorageInterface $storage): JsonResponse
    {
        return new JsonResponse([
            'items' => \array_map(function (Transaction $transaction): array {
                return \array_merge($transaction->toArray(), [
                    'active' => false,
                ]);
            }, $storage->findTransactions())
        ]);
    }
}
