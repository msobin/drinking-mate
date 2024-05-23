<?php

declare(strict_types=1);

namespace App\Controller\Api\v1\Request;

use App\Operation\Command\SyncCommandInterface;
use OpenApi\Attributes as OA;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class MateMessageRequest implements SyncCommandInterface
{
    public function __construct(
        #[Assert\Uuid]
        #[OA\Property(type: 'string', format: 'uuid')]
        public string $to,
        #[Assert\NotBlank]
        #[Assert\Length(max: 255)]
        public string $message,
    ) {
    }
}
