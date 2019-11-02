<?php

declare(strict_types=1);

namespace App\Smoney\Response;

use App\Gateway\Response\ResponseCaptureInterface;
use App\Gateway\TransactionInterface;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\UriInterface;

class ResponseCapture implements ResponseCaptureInterface
{
    /** @var string  */
    private $reference;

    /** @var string  */
    private $redirect;

    /** @var string */
    private $callback;

    /** @var bool  */
    private $error;

    public function __construct(TransactionInterface $transaction, bool $error = false)
    {
        $this->redirect = $transaction->getData()['UrlReturn'];
        $this->reference = $transaction->getData()['OrderId'];
        $this->callback = $transaction->getData()['UrlReturn'];
        $this->error = $error;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->reference,
            'type' => $this->error ? 0 : 1,
        ];
    }

    public function getRedirect(): UriInterface
    {
        return new Uri($this->redirect . '&' . http_build_query($this->toArray()));
    }

    public function getCallback(): UriInterface
    {
        return new Uri($this->callback);
    }
}
