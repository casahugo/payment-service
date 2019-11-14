<?php

declare(strict_types=1);

namespace App\Gateway\Notification;

use App\ArrayableInterface;

class Notify
{
    /** @var string  */
    private $url;

    /** @var null|ArrayableInterface  */
    private $data;

    public function __construct(string $url, ArrayableInterface $data = null)
    {
        $this->url = $url;
        $this->data = $data;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getData(): ?array
    {
        return is_null($this->data) ? null : $this->data->toArray();
    }
}
