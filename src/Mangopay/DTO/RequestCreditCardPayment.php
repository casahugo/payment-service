<?php

declare(strict_types=1);

namespace App\Mangopay\DTO;

use App\ArrayableInterface;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\UriInterface;

class RequestCreditCardPayment implements ArrayableInterface
{
    /** @var int  */
    private $id;

    /** @var string  */
    private $redirectUrl;
    /**
     * @var string
     */
    private $callbackUrl;

    public function __construct(string $redirectUrl, string $callbackUrl, int $id)
    {
        $this->redirectUrl = $redirectUrl;
        $this->callbackUrl = $callbackUrl;
        $this->id = $id;
    }

    public function getEndpoint(): UriInterface
    {
        return new Uri(urldecode($this->callbackUrl));
    }

    public function getRedirectUrl(): UriInterface
    {
        return new Uri(urldecode($this->redirectUrl . http_build_query($this->toArray())));
    }

    public function toArray(): array
    {
        return [
            'transactionId' => $this->id,
        ];
    }
}
