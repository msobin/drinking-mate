<?php

declare(strict_types=1);

namespace App\Operation\CommandHandler;

use App\Operation\Command\FileUploadCommand;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

final readonly class FilesCommandHandler
{
    #[AsMessageHandler]
    public function mateMessage(FileUploadCommand $command): void
    {
    }
}
