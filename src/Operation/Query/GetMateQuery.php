<?php

declare(strict_types=1);

namespace App\Operation\Query;

use App\Infrastructure\Uuid\Uuid;

final readonly class GetMateQuery implements QueryInterface
{
    public function __construct(
        public Uuid $uuid
    ) {
    }
}
