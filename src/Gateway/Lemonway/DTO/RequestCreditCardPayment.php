<?php

declare(strict_types=1);

namespace App\Gateway\Lemonway\DTO;

use App\ArrayableInterface;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\UriInterface;

class RequestCreditCardPayment implements ArrayableInterface
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

    public function getEndpoint(): UriInterface
    {
        return new Uri($this->endpoint);
    }

    public function getRedirect(): UriInterface
    {
        return new Uri($this->endpoint . http_build_query($this->toArray()));
    }

    public function toArray(): array
    {
        return [
            'response_transactionId' => $this->id,
            'response_wkToken' => $this->reference,
        ];
    }
}
