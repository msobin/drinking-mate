<?php

declare(strict_types=1);

namespace App\Operations\Command;

use App\Infrastructure\Uuid\Uuid;

final readonly class MateMessageCommand implements CommandInterface
{
    public function __construct(
        public Uuid $from,
        public Uuid $to,
        public string $message,
    ) {
    }
}
