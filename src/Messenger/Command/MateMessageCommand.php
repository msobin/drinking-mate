<?php

declare(strict_types=1);

namespace App\Messenger\Command;

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
