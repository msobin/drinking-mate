<?php

declare(strict_types=1);

namespace App\Operations\Query;

use App\Entity\Mate;

final readonly class GetMessagesQuery implements QueryInterface
{
    public function __construct(
        public Mate $mate
    ) {
    }
}
