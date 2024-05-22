<?php

declare(strict_types=1);

namespace App\Api\v1;

use App\Api\v1\Request\WannaDrinkRequest;
use App\Entity\Mate;
use App\Infrastructure\Uuid\Uuid;
use App\Operation\Command\FileUploadCommand;
use App\Operation\Command\WannaDrinkSyncCommand;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Attributes as OA;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Property;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

#[OA\Tag(name: 'auth')]
#[Security]
final class AuthController extends ApiController
{
    public function __construct(private readonly MessageBusInterface $messageBus)
    {
    }

    #[Route('/api/v1/wanna-drink', name: 'wanna_drink', methods: ['POST'])]
    #[OA\RequestBody(request: WannaDrinkRequest::class)]
    #[OA\Response(
        response: Response::HTTP_CREATED,
        description: 'Returns a JWT token',
        content: new JsonContent(
            properties: [new Property(property: 'token', description: 'JWT token')]
        )
    )]
    public function wannaDrink(
        #[MapRequestPayload] WannaDrinkRequest $request,
        JWTTokenManagerInterface $JWTManager
    ): Response {
        $command = new WannaDrinkSyncCommand(
            Uuid::v7(),
            $request->name,
            $request->description,
            $request->latitude,
            $request->longitude
        );

        $this->messageBus->dispatch($command);
        $this->messageBus->dispatch(new FileUploadCommand());

        return new JsonResponse(
            ['token' => $JWTManager->create((new Mate())->setId($command->id))],
            Response::HTTP_CREATED
        );
    }
}
