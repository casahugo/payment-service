<?php

declare(strict_types=1);

namespace App\Mangopay\Action;

use App\Gateway\Action\ActionInterface;
use App\Gateway\Request\Transaction;
use App\Gateway\TransactionInterface;
use App\Mangopay\Mangopay;
use App\Mangopay\Response\ResponseTransaction;

class TransactionAction implements ActionInterface
{
    /**
     * @param TransactionInterface $request
     * @return ResponseTransaction
     */
    public function execute($request): ResponseTransaction
    {
        return new ResponseTransaction($request);
    }

    public function supports($request, string $class): bool
    {
        return $request instanceof Transaction && Mangopay::class === $class;
    }
}
