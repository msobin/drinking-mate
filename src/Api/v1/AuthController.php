<?php

declare(strict_types=1);

namespace App\Api\v1;

use App\Entity\Mate;
use App\Infrastructure\Uuid\Uuid;
use App\Messenger\Command\WannaDrinkCommand;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

final class AuthController extends ApiController
{
    public function __construct(private readonly MessageBusInterface $messageBus)
    {
    }

    #[Route('/api/v1/wanna-drink', methods: ['POST'])]
    public function wannaDrink(#[MapRequestPayload] WannaDrinkCommand $command, JWTTokenManagerInterface $JWTManager): Response
    {
        $command->setId(Uuid::v7());

        $this->messageBus->dispatch($command);

        return new JsonResponse(
            ['token' => $JWTManager->create((new Mate())->setId($command->id))],
            Response::HTTP_CREATED
        );
    }
}
