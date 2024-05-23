<?php

declare(strict_types=1);

namespace App\Entity;

use App\Infrastructure\Point\Point;
use App\Infrastructure\Point\PointType;
use App\Infrastructure\Uuid\Uuid;
use App\Infrastructure\Uuid\UuidType;
use App\Repository\MateRepository;
use Doctrine\ORM\Mapping as ORM;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use OpenApi\Attributes as OA;

#[ORM\Entity(repositoryClass: MateRepository::class)]
#[ORM\Index(fields: ['point'])]
#[ORM\HasLifecycleCallbacks]
class Mate implements UserInterface, \JsonSerializable
{
    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 2;

    #[ORM\Id, ORM\Column(type: UuidType::class)]
    #[OA\Property(type: 'string', format: 'uuid'), Groups(['api'])]
    private Uuid $id;

    #[ORM\Column]
    #[Assert\NotBlank, Assert\Length(min: 1, max: 255)]
    #[Groups(['api'])]
    private string $name;

    #[ORM\Column]
    #[Assert\NotBlank, Assert\Length(min: 1, max: 255)]
    #[Groups(['api'])]
    private string $description;

    #[ORM\Column(type: PointType::class)]
    #[Assert\NotBlank]
    #[OA\Property(ref: new Model(type: Point::class), type: 'object'), Groups(['api'])]
    private Point $point;

    #[Assert\NotBlank]
    #[ORM\Column(type: 'smallint', options: ['default' => self::STATUS_ACTIVE])]
    private int $status = self::STATUS_ACTIVE;

    #[Assert\NotBlank]
    #[ORM\Column(type: 'bigint')]
    private int $createdAt;

    #[Assert\NotBlank]
    #[ORM\Column(type: 'bigint')]
    #[OA\Property(type: 'integer'), Groups(['api'])]
    private int $lastActiveAt;

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function setId(Uuid $id): Mate
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Mate
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): Mate
    {
        $this->description = $description;

        return $this;
    }

    public function getPoint(): Point
    {
        return $this->point;
    }

    public function setPoint(Point $point): Mate
    {
        $this->point = $point;

        return $this;
    }

    public function getRoles(): array
    {
        return [];
    }

    public function eraseCredentials(): void
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->id->toString();
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $status): Mate
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): int
    {
        return $this->createdAt;
    }


    public function setCreatedAt(int $createdAt): Mate
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getLastActiveAt(): int
    {
        return $this->lastActiveAt;
    }

    public function setLastActiveAt(int $lastActiveAt): Mate
    {
        $this->lastActiveAt = $lastActiveAt;

        return $this;
    }

    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        $time = time();

        $this->setCreatedAt($time);
        $this->setLastActiveAt($time);
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id->toString(),
            'name' => $this->name,
            'description' => $this->description,
            'point' => $this->point,
            'lastActiveAt' => $this->lastActiveAt,
        ];
    }
}
