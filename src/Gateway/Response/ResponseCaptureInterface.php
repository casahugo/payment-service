<?php

declare(strict_types=1);

namespace App\Gateway\Response;

use App\ArrayableInterface;
use Psr\Http\Message\UriInterface;

interface ResponseCaptureInterface extends ArrayableInterface
{
    public function getRedirect(): UriInterface;

    public function getCallback(): UriInterface;
}
