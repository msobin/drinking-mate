<?php

declare(strict_types=1);

namespace App\Operation\Command;

use App\Infrastructure\Uuid\Uuid;

final readonly class WannaDrinkCommand implements SyncCommandInterface
{
    public function __construct(
        public Uuid $id,
        public string $name,
        public string $description,
        public float $latitude,
        public float $longitude
    ) {
    }
}
