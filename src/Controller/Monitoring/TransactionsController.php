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
            'items' => array_map(function (Transaction $transaction): array {
                return [
                    'id' => $transaction->getId(),
                    'reference' => $transaction->getReference(),
                    'processorName' => $transaction->getProcessorName(),
                    'type' => $transaction->getType(),
                    'data' => $transaction->getData(),
                    'active' => false,
                ];
            }, $storage->findTransactions())
        ]);
    }
}
