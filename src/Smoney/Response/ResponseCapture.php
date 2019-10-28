<?php

declare(strict_types=1);

namespace App\Smoney\Response;

use App\Gateway\Contract\ResponseCaptureInterface;
use App\Gateway\TransactionInterface;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\UriInterface;

class ResponseCapture implements ResponseCaptureInterface
{
    /** @var string  */
    private $reference;

    /** @var string  */
    private $redirect;

    /** @var  */
    private $callback;

    public function __construct(TransactionInterface $transaction, bool $error = false)
    {
        $this->redirect = $transaction->getData()['UrlReturn'];
        $this->reference = $transaction->getReference();
        $this->callback = $transaction->getData()['UrlCallback'];
    }

    public function toArray(): array
    {
        return [
            'id' => $this->reference,
        ];
    }

    public function getRedirect(): UriInterface
    {
        return new Uri($this->redirect . '?' . http_build_query($this->toArray()));
    }

    public function getCallback(): UriInterface
    {
        return new Uri($this->callback);
    }
}
