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

    /** @var null|\DateTime */
    private $createdAt;

    /** @var null|\DateTime */
    private $updatedAt;

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

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'url' => $this->getUrl(),
            'processorName' => preg_replace(
                '#(App\\\(.*)\\\)#',
                '',
                $this->getProcessorName()
            ),
            'status' => $this->getStatus(),
            'event' => $this->getEvent(),
            'data' => $this->getData(),
            'createdAt' => $this->getCreatedAt()->format(\DateTime::RFC3339),
            'updatedAt' => $this->getUpdatedAt()->format(\DateTime::RFC3339),
            'active' => false,
        ];
    }
}
