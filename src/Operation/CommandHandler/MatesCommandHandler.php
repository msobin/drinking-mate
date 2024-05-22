<?php

declare(strict_types=1);

namespace App\Operation\CommandHandler;

use App\Entity\Mate;
use App\Operation\Command\WannaDrinkSyncCommand;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

final readonly class MatesCommandHandler
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    #[AsMessageHandler]
    public function wannaDrink(WannaDrinkSyncCommand $command): void
    {
        $mate = new Mate();

        $mate->setId($command->id);
        $mate->setName($command->name);
        $mate->setDescription($command->description);
        $mate->setPoint("SRID=4326;POINT($command->longitude $command->latitude)");

        $this->entityManager->persist($mate);
        $this->entityManager->flush();
    }
}
