<?php
/**
 * @author      Wizacha DevTeam <dev@wizacha.com>
 * @copyright   Copyright (c) Wizacha
 * @license     Proprietary
 */
declare(strict_types=1);

namespace App\Gateway\Lemonway\DTO;

class RequestCreditCardPayment
{
    /** @var int  */
    private $id;

    /** @var string  */
    private $reference;

    /** @var string  */
    private $endpoint;

    public function __construct(string $endpoint, int $id, string $reference)
    {
        $this->endpoint = $endpoint;
        $this->id = $id;
        $this->reference = $reference;
    }

    public function getEndpoint(): string
    {
        return urldecode($this->endpoint);
    }

    public function getRedirect(): string
    {
        return urldecode($this->endpoint . http_build_query($this->toArray()));
    }

    public function toArray(): array
    {
        return [
            'response_transactionId' => $this->id,
            'response_wkToken' => $this->reference,
        ];
    }
}