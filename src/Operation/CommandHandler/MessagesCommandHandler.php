<?php

declare(strict_types=1);

namespace App\Operation\CommandHandler;

use App\Entity\MateMessage;
use App\Infrastructure\Uuid\Uuid;
use App\Operation\Command\MateMessageCommand;
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
        $mateMessage->setFromId($command->from);
        $mateMessage->setToId($command->to);
        $mateMessage->setMessage($command->message);

        $this->entityManager->persist($mateMessage);
        $this->entityManager->flush();
    }
}
