<?php

declare(strict_types=1);

namespace App\Messenger\Command;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class MateMessageCommand implements CommandInterface
{
    public string $from;

    public function __construct(
        #[Assert\Uuid]
        public string $to,
        #[Assert\NotBlank]
        #[Assert\Length(max: 255)]
        public string $message,
    ) {
    }

    public function setFrom(string $from): void
    {
        $this->from = $from;
    }
}
