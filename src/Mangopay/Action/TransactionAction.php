<?php

declare(strict_types=1);

namespace App\Mangopay\Action;

use App\Gateway\Action\AbstractAction;
use App\Gateway\Request\Transaction;
use App\Gateway\TransactionInterface;
use App\Mangopay\Mangopay;
use App\Mangopay\Response\ResponseTransaction;

class TransactionAction extends AbstractAction
{
    /**
     * @param TransactionInterface $request
     * @return ResponseTransaction
     */
    public function execute($request)
    {
        $transaction = $this->storage->findTransaction($request->getId());

        return new ResponseTransaction($transaction->getId(), $transaction->getData());
    }

    public function supports($request, string $class): bool
    {
        return $request instanceof Transaction && Mangopay::class === $class;
    }
}
