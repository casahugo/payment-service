<?php

declare(strict_types=1);

namespace App\Gateway\Response;

use Psr\Http\Message\UriInterface;

class ResponseCheckout
{
    /** @var string  */
    private $reference;

    /** @var UriInterface  */
    private $action;

    public function __construct(string $reference, UriInterface $action)
    {
        $this->reference = $reference;
        $this->action = $action;
    }

    public function getReference(): string
    {
        return $this->reference;
    }

    public function getAction(): UriInterface
    {
        return $this->action;
    }
}
