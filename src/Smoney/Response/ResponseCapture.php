<?php

declare(strict_types=1);

namespace App\Smoney\Response;

use App\Gateway\Contract\ResponseCaptureInterface;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\UriInterface;

class ResponseCapture implements ResponseCaptureInterface
{
    /** @var int  */
    private $id;

    /** @var string  */
    private $reference;

    /** @var string  */
    private $redirect;
    /**
     * @var string
     */
    private $callback;

    public function __construct(string $redirect, string $callback, int $id, string $reference)
    {
        $this->redirect = $redirect;
        $this->id = $id;
        $this->reference = $reference;
        $this->callback = $callback;
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
