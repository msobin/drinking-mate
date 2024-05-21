<?php

declare(strict_types=1);

namespace App\Messenger\Command;

use App\Infrastructure\Uuid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class WannaDrinkCommand implements CommandInterface
{
    public Uuid $id;

    public function __construct(
        public string $name,
        #[Assert\NotBlank]
        #[Assert\Length(max: 255)]
        public string $description,
        #[Assert\Range(min: -90, max: 90)]
        public float $latitude,
        #[Assert\Range(min: -90, max: 90)]
        public float $longitude
    ) {
    }

    public function setId(Uuid $id): void
    {
        $this->id = $id;
    }
}
