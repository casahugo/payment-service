<?php

namespace App\Entity;

use App\ArrayableInterface;
use App\Gateway\TransactionInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TransactionRepository")
 */
class Transaction implements TransactionInterface, ArrayableInterface
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
    private $reference;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $processorName;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $type;

    /**
     * @ORM\Column(type="text", nullable=true)
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

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getProcessorName(): ?string
    {
        return $this->processorName;
    }

    public function setProcessorName(string $processorName): self
    {
        $this->processorName = $processorName;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getData(): ?array
    {
        if (is_array($this->data) or is_null($this->data)) {
            return $this->data;
        }

        return unserialize($this->data);
    }

    public function setData(?array $data): self
    {
        $this->data = serialize($data);

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
            'reference' => $this->getReference(),
            'processorName' => preg_replace('#(App\\\(.*)\\\)#', '', $this->getProcessorName()),
            'type' => $this->getType(),
            'data' => $this->getData(),
            'createdAt' => $this->getCreatedAt()->format(\DateTime::RFC3339),
            'updatedAt' => $this->getUpdatedAt()->format(\DateTime::RFC3339),
            'active' => false,
        ];
    }
}
