<?php

declare(strict_types=1);

namespace App\Gateway\Notification;

use App\ArrayableInterface;
use GuzzleHttp\Client;

class Notification
{
    /** @var Client  */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function notify(string $url, ArrayableInterface $data = null)
    {
        $this->client->post($url, is_null($data) ? [] : $data->toArray());
    }
}
