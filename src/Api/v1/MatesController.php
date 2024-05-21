<?php

declare(strict_types=1);

namespace App\Api\v1;

use App\Entity\Mate;
use App\Infrastructure\Uuid\Uuid;
use App\Messenger\Query\GetMateQuery;
use App\Messenger\Query\GetNearByQuery;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\UserInterface;

#[Route('/api/v1/mates')]
final class MatesController extends ApiController
{
    public function __construct(private readonly MessageBusInterface $messageBus)
    {
    }

    #[Route('/nearby', methods: ['GET'])]
    public function getNearBy(UserInterface $mate, ParameterBagInterface $parameterBag): Response
    {
        /** @var Mate $mate */
        $envelope = $this->messageBus->dispatch(
            new GetNearByQuery(
                $mate, $parameterBag->get('mate_nearby_distance')
            )
        );

        return $this->getResultResponse($envelope);
    }

    #[Route('/{id}', methods: ['GET'])]
    public function getMate(string $id): Response
    {
        $envelope = $this->messageBus->dispatch(new GetMateQuery(Uuid::fromString($id)));

        return $this->getResultResponse($envelope);
    }
}
