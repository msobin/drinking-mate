<?php

declare(strict_types=1);

namespace App\Operation\Command;

use App\Infrastructure\Uuid\Uuid;

final readonly class MateMessageSyncCommand implements SyncCommandInterface
{
    public function __construct(
        public Uuid $from,
        public Uuid $to,
        public string $message,
    ) {
    }
}
