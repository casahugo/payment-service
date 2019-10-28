<?php

declare(strict_types=1);

namespace App\Lemonway\Response;

use App\Gateway\Contract\ResponseCaptureInterface;
use App\Gateway\TransactionInterface;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\UriInterface;

class ResponseCapture implements ResponseCaptureInterface
{
    /** @var int  */
    private $id;

    /** @var string  */
    private $reference;

    /** @var string  */
    private $endpoint;

    public function __construct(TransactionInterface $transaction, bool $error = false)
    {
        $this->endpoint = $error ? $transaction->getData()['errorUrl'] : $transaction->getData()['returnUrl'];
        $this->id = $transaction->getId();
        $this->reference = $transaction->getReference();
    }

    public function getCallback(): UriInterface
    {
        return new Uri(urldecode($this->endpoint));
    }

    public function getRedirect(): UriInterface
    {
        return new Uri(urldecode($this->endpoint . '?' . http_build_query($this->toArray())));
    }

    public function toArray(): array
    {
        return [
            'response_transactionId' => $this->id,
            'response_wkToken' => $this->reference,
        ];
    }
}
