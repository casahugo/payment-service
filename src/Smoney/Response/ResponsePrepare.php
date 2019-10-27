<?php

declare(strict_types=1);

namespace App\Smoney\Response;

use App\ArrayableInterface;

class ResponsePrepare implements ArrayableInterface
{
    /** @var int  */
    private $id;

    /** @var string  */
    private $url;
    /**
     * @var array
     */
    private $data;

    public function __construct(int $id, string $url, array $data)
    {
        $this->id = $id;
        $this->url = $url;
        $this->data = $data;
    }

    public function toArray(): array
    {
        return [
            'ErrorCode' => 0,
            'ErrorMessage' => null,
            'Href' => $this->url,
            'Id' => $this->id,
            'OrderId' => $this->data['OrderId'] ?? null,
        ];
    }
}
