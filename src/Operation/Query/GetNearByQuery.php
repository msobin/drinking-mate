<?php

declare(strict_types=1);

namespace App\Operation\Query;

use App\Entity\Mate;

final readonly class GetNearByQuery implements QueryInterface
{
    public function __construct(
        public Mate $mate,
        public int $distance,
    ) {
    }
}
