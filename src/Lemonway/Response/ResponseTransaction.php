<?php

declare(strict_types=1);

namespace App\Lemonway\Response;

use App\ArrayableInterface;
use App\Gateway\TransactionInterface;

class ResponseTransaction implements ArrayableInterface
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $wallet;
    /**
     * @var float
     */
    private $amount;
    /**
     * @var string
     */
    private $comment;

    public function __construct(TransactionInterface $transaction)
    {
        $this->id = $transaction->getId();
        $this->wallet = $transaction->getData()['wallet'];
        $this->amount = (float) $transaction->getData()['amountTot'];
        $this->comment = $transaction->getData()['comment'];
    }

    public function toArray(): array
    {
        return [
            'd' => [
                'TRANS' => [
                    'HPAY' => [
                        [
                            'ID' => (string) $this->id,
                            'DATE' => (new \DateTime())->format('m/d/Y H:i:s'),
                            'REC' => $this->wallet,
                            'DEB' => '0.00',
                            'CRED' => $this->amount,
                            'COM' => '0.0',
                            'MSG' => $this->comment,
                            'STATUS' => '3',
                            'EXTRA' => [],
                        ]
                    ],
                ],
            ],
        ];
    }
}
