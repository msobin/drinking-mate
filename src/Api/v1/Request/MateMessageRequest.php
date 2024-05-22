<?php

declare(strict_types=1);

namespace App\Api\v1\Request;

use App\Operation\Command\CommandInterface;
use Symfony\Component\Validator\Constraints as Assert;
use OpenApi\Attributes as OA;

final readonly class MateMessageRequest implements CommandInterface
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
