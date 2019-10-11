<?php
/**
 * @author      Wizacha DevTeam <dev@wizacha.com>
 * @copyright   Copyright (c) Wizacha
 * @license     Proprietary
 */
declare(strict_types=1);

namespace App\Gateway\Lemonway\DTO;

class ResponseCreditCard
{
    /** @var string  */
    private $reference;

    /** @var int  */
    private $id;

    /** @var int|null  */
    private $cardNumber;

    public function __construct(string $reference, int $id, ?int $cardNumber = null)
    {
        $this->reference = $reference;
        $this->id = $id;
        $this->cardNumber = $cardNumber;
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