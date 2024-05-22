<?php

declare(strict_types=1);

namespace App\Api\v1;

use App\Api\v1\Request\MateMessageRequest;
use App\Entity\Mate;
use App\Entity\MateMessage;
use App\Infrastructure\Uuid\Uuid;
use App\Messenger\Command\MateMessageCommand;
use App\Messenger\Query\GetMessagesQuery;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use OpenApi\Attributes as OA;

#[Route('/api/v1/messages')]
#[OA\Tag(name: 'messages')]
#[Security(name: 'Bearer')]
final class MessagesController extends ApiController
{
    public function __construct(private readonly MessageBusInterface $messageBus)
    {
    }

    #[Route('', methods: ['GET'])]
    #[OA\Response(
        response: Response::HTTP_OK,
        description: 'Returns a list of messages',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: MateMessage::class, groups: ['api']))
        )
    )]
    public function getMessages(UserInterface $mate): Response
    {
        /** @var Mate $mate */
        $envelope = $this->messageBus->dispatch(new GetMessagesQuery($mate));

        return $this->getResultResponse($envelope);
    }

    #[Route('', methods: ['POST'])]
    #[OA\RequestBody(request: MateMessageRequest::class)]
    #[OA\Response(
        response: Response::HTTP_CREATED,
        description: 'Send a message to a mate',
    )]
    public function sendMessage(#[MapRequestPayload] MateMessageRequest $request, UserInterface $mate): Response
    {
        /** @var Mate $mate */
        $command = new MateMessageCommand(
            $mate->getId(),
            Uuid::fromString($request->to),
            $request->message
        );

        $this->messageBus->dispatch($command);

        return new Response(null, Response::HTTP_CREATED);
    }
}
