<?php

declare(strict_types=1);

namespace App\Gateway\Response;

use App\Gateway\TransactionInterface;
use Psr\Http\Message\UriInterface;

class ResponseCheckout
{
    /** @var TransactionInterface  */
    private $transaction;

    /** @var UriInterface  */
    private $action;

    public function __construct(TransactionInterface $transaction, UriInterface $action)
    {
        $this->transaction = $transaction;
        $this->action = $action;
    }

    public function getTransaction(): TransactionInterface
    {
        return $this->transaction;
    }

    public function getAction(): UriInterface
    {
        return $this->action;
    }
}
