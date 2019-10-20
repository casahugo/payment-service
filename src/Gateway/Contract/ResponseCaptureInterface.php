<?php

declare(strict_types=1);

namespace App\Gateway\Contract;

use App\ArrayableInterface;
use Psr\Http\Message\UriInterface;

interface ResponseCaptureInterface extends ArrayableInterface
{
    public function getRedirect(): UriInterface;

    public function getCallback(): UriInterface;
}
