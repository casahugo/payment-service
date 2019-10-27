<?php

declare(strict_types=1);

namespace App\Smoney\Action;

use App\Gateway\Action\AbstractAction;
use App\Gateway\Request\Transaction;
use App\Gateway\TransactionInterface;
use App\Smoney\Response\ResponseTransaction;
use App\Smoney\Smoney;

class TransactionAction extends AbstractAction
{
    /**
     * @param TransactionInterface $request
     * @return ResponseTransaction
     */
    public function execute($request)
    {
        $transaction = $this->storage->findTransaction(
            $request->getId(),
            $request->getReference()
        );

        $data = $transaction->getData();

        return new ResponseTransaction(
            $transaction->getId(),
            $data['wallet'],
            (float) $data['amountTot'],
            $data['comment']
        );
    }

    public function supports($request, string $class): bool
    {
        return $request instanceof Transaction && Smoney::class === $class;
    }
}
