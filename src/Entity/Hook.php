<?php

namespace App\Entity;

use App\ArrayableInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HookRepository")
 */
class Hook implements ArrayableInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $event;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $processorName;

    /**
     * @ORM\Column(type="text" nullable=true)
     */
    private $data;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getEvent(): ?string
    {
        return $this->event;
    }

    public function setEvent(?string $event): self
    {
        $this->event = $event;

        return $this;
    }

    public function getProcessorName(): string
    {
        return $this->processorName;
    }

    public function setProcessorName(string $processorName): self
    {
        $this->processorName = $processorName;

        return $this;
    }

    public function getData(): ?array
    {
        return \unserialize($this->data);
    }

    public function setData(array $data): self
    {
        $this->data = \serialize($data);

        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'url' => $this->getUrl(),
            'processorName' => $this->getProcessorName(),
            'status' => $this->getStatus(),
            'event' => $this->getEvent(),
            'data' => $this->getData(),
            'active' => false,
        ];
    }
}
