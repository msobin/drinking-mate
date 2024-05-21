<?php

declare(strict_types=1);

namespace App\Api\v1;

use App\Entity\Mate;
use App\Messenger\Command\MateMessageCommand;
use App\Messenger\Query\GetMessagesQuery;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\UserInterface;

#[Route('/api/v1/messages')]
final class MessagesController extends ApiController
{
    public function __construct(private readonly MessageBusInterface $messageBus)
    {
    }

    #[Route('', methods: ['GET'])]
    public function getMessages(UserInterface $mate): Response
    {
        /** @var Mate $mate */
        $envelope = $this->messageBus->dispatch(new GetMessagesQuery($mate));

        return $this->getResultResponse($envelope);
    }

    #[Route('', methods: ['POST'])]
    public function sendMessage(#[MapRequestPayload] MateMessageCommand $command, UserInterface $mate): Response
    {
        $command->setFrom($mate->getId()->toString());

        $this->messageBus->dispatch($command);

        return new Response(null, Response::HTTP_CREATED);
    }
}
