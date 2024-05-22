<?php

declare(strict_types=1);

namespace App\Api\v1;

use App\Entity\Mate;
use App\Infrastructure\Uuid\Uuid;
use App\Operations\Query\GetMateQuery;
use App\Operations\Query\GetNearByQuery;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Attributes as OA;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\UserInterface;

#[Route('/api/v1/mates')]
#[OA\Tag(name: 'mates')]
#[Security(name: 'Bearer')]
final class MatesController extends ApiController
{
    public function __construct(private readonly MessageBusInterface $messageBus)
    {
    }

    #[Route('/nearby', name: 'get_near_by', methods: ['GET'])]
    #[OA\Response(
        response: Response::HTTP_OK,
        description: 'Returns a list of mates nearby',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: Mate::class, groups: ['api']))
        )
    )]
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

    #[Route('/{id}', name: 'get_mate', methods: ['GET'])]
    #[OA\Response(
        response: Response::HTTP_OK,
        description: 'Returns a mate by id',
        content: new Model(type: Mate::class, groups: ['api']),
    )]
    public function getMate(string $id): Response
    {
        $envelope = $this->messageBus->dispatch(new GetMateQuery(Uuid::fromString($id)));

        return $this->getResultResponse($envelope);
    }
}
