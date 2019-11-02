<?php

declare(strict_types=1);

namespace App\Smoney\Response;

use App\ArrayableInterface;
use App\Gateway\TransactionInterface;

class ResponsePrepare implements ArrayableInterface
{
    /** @var int  */
    private $id;

    /** @var string  */
    private $url;
    /**
     * @var array
     */
    private $data;

    public function __construct(TransactionInterface $transaction, string $url)
    {
        $this->id = $transaction->getId();
        $this->url = $url;
        $this->data = $transaction->getData();
    }

    public function toArray(): array
    {
        return [
            'ErrorCode' => 0,
            'ErrorMessage' => null,
            'Href' => $this->url,
            'Id' => $this->id,
            'OrderId' => $this->data['OrderId'] ?? null,
        ];
    }
}
