<?php

namespace App\Entity;

use App\Infrastructure\Uuid\Uuid;
use App\Infrastructure\Uuid\UuidType;
use App\Repository\MateMessageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MateMessageRepository::class)]
#[ORM\Index(fields: ['toId'])]
#[ORM\HasLifecycleCallbacks]
class MateMessage implements \JsonSerializable
{
    #[ORM\Id, ORM\Column(type: UuidType::class)]
    #[Groups(['api'])]
    private Uuid $id;

    #[ORM\Id, ORM\Column(type: UuidType::class)]
    private Uuid $toId;

    #[ORM\Id, ORM\Column(type: UuidType::class)]
    #[Groups(['api'])]
    private Uuid $fromId;

    #[ORM\Column]
    #[Assert\NotBlank, Assert\Length(min: 1, max: 255)]
    #[Groups(['api'])]
    private string $message;

    #[Assert\NotBlank]
    #[ORM\Column(type: 'bigint')]
    #[Groups(['api'])]
    private int $createdAt;

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function setId(Uuid $id): MateMessage
    {
        $this->id = $id;

        return $this;
    }

    public function getToId(): Uuid
    {
        return $this->toId;
    }

    public function setToId(Uuid $toId): MateMessage
    {
        $this->toId = $toId;

        return $this;
    }


    public function getFromId(): Uuid
    {
        return $this->fromId;
    }

    public function setFromId(Uuid $fromId): MateMessage
    {
        $this->fromId = $fromId;

        return $this;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): MateMessage
    {
        $this->message = $message;

        return $this;
    }

    public function getCreatedAt(): int
    {
        return $this->createdAt;
    }

    public function setCreatedAt(int $createdAt): MateMessage
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        $time = time();

        $this->setCreatedAt($time);
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id->toString(),
            'from' => $this->fromId->toString(),
            'message' => $this->message,
            'createdAt' => $this->createdAt,
        ];
    }
}
