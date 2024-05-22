<?php

declare(strict_types=1);

namespace App\Operation\Command;

final readonly class FileUploadCommand
{
    public function __construct(
        public string $filename = 'test',
        public string $content = 'content',
    ) {
    }
}
