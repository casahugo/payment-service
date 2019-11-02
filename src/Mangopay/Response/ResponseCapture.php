<?php

declare(strict_types=1);

namespace App\Mangopay\Response;

use App\Gateway\Response\ResponseCaptureInterface;
use App\Gateway\TransactionInterface;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\UriInterface;

class ResponseCapture implements ResponseCaptureInterface
{
    /** @var int  */
    private $id;

    /** @var string  */
    private $redirectUrl;

    /** @var string */
    private $callbackUrl;

    /** @var bool  */
    private $error;

    public function __construct(TransactionInterface $transaction, bool $error = false)
    {
        $this->redirectUrl = $transaction->getData()['ReturnURL'];
        $this->callbackUrl = $transaction->getData()['ReturnURL'];
        $this->id = $transaction->getId();
        $this->error = $error;
    }

    public function getCallback(): UriInterface
    {
        return new Uri(urldecode($this->callbackUrl . '&transactionId=' . $this->id));
    }

    public function getRedirect(): UriInterface
    {
        return new Uri(urldecode($this->redirectUrl . '&transactionId=' . $this->id));
    }

    public function toArray(): array
    {
        return [
            'transactionId' => $this->id,
        ];
    }
}
