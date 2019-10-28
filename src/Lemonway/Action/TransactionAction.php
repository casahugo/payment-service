<?php

declare(strict_types=1);

namespace App\Lemonway\Action;

use App\ArrayableInterface;
use App\Gateway\Action\ActionInterface;
use App\Gateway\Request\Transaction;
use App\Gateway\TransactionInterface;
use App\Lemonway\Lemonway;
use App\Lemonway\Response\ResponseTransaction;

class TransactionAction implements ActionInterface
{
    /**
     * @param TransactionInterface $request
     * @return ArrayableInterface
     */
    public function execute($request): ArrayableInterface
    {
        return new ResponseTransaction($request);
    }

    public function supports($request, string $class): bool
    {
        return $request instanceof Transaction && Lemonway::class === $class;
    }
}
