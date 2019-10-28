<?php

declare(strict_types=1);

namespace App\Lemonway\Response;

use App\ArrayableInterface;
use App\Gateway\TransactionInterface;
use Faker\Factory;

class ResponsePrepare implements ArrayableInterface
{
    /** @var string  */
    private $reference;

    /** @var int  */
    private $id;

    /** @var int|null  */
    private $cardNumber;

    public function __construct(TransactionInterface $transaction)
    {
        $this->reference = $transaction->getReference();
        $this->id = $transaction->getId();
        $this->cardNumber = (int) $transaction->getData()['registerCard'] === 1
            ? Factory::create()->randomNumber()
            : null;
    }

    public function toArray(): array
    {
        return [
            'd' => [
                'MONEYINWEB' => [
                    'TOKEN' => $this->reference,
                    'ID' => $this->id,
                    'CARD' => [
                        'ID' => $this->cardNumber,
                    ],
                    'REDIRECTURL' => null,
                ],
            ],
        ];
    }
}
