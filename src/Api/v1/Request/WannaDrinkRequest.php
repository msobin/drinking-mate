<?php

declare(strict_types=1);

namespace App\Api\v1\Request;

use Symfony\Component\Validator\Constraints as Assert;

final class WannaDrinkRequest
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(max: 255)]
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
}
