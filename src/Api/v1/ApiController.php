<?php

declare(strict_types=1);

namespace App\Api\v1;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Stamp\HandledStamp;

abstract class ApiController extends AbstractController
{
    protected function getResultResponse(Envelope $envelope): JsonResponse
    {
        return new JsonResponse($envelope->last(HandledStamp::class)->getResult());
    }
}
