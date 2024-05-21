<?php

declare(strict_types=1);

namespace App\Messenger\CommandHandler;

use App\Entity\MateMessage;
use App\Infrastructure\Uuid\Uuid;
use App\Messenger\Command\MateMessageCommand;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

final readonly class MessagesCommandHandler
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    #[AsMessageHandler]
    public function mateMessage(MateMessageCommand $command): void
    {
        $mateMessage = new MateMessage();

        $mateMessage->setId(Uuid::v7());
        $mateMessage->setFromId(Uuid::fromString($command->from));
        $mateMessage->setToId(Uuid::fromString($command->to));
        $mateMessage->setMessage($command->message);

        $this->entityManager->persist($mateMessage);
        $this->entityManager->flush();
    }
}
