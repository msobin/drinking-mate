<?php

declare(strict_types=1);

namespace App\Operation\CommandHandler;

use App\Entity\Mate;
use App\Operation\Command\WannaDrinkCommand;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use App\Infrastructure\Point\Point;

final readonly class MatesCommandHandler
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    #[AsMessageHandler]
    public function wannaDrink(WannaDrinkCommand $command): void
    {
        $mate = new Mate();

        $mate->setId($command->id);
        $mate->setName($command->name);
        $mate->setDescription($command->description);
        $mate->setPoint(Point::fromCoordinates($command->latitude, $command->longitude));

        $this->entityManager->persist($mate);
        $this->entityManager->flush();
    }
}
