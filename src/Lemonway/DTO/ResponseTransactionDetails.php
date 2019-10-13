<?php

declare(strict_types=1);

namespace App\Lemonway\DTO;

class ResponseTransactionDetails
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

    public function __construct(int $id, string $wallet, float $amount, string $comment)
    {
        $this->id = $id;
        $this->wallet = $wallet;
        $this->amount = $amount;
        $this->comment = $comment;
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
