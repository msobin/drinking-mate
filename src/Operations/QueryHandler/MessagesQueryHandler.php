<?php

declare(strict_types=1);

namespace App\Operations\QueryHandler;

use App\Operations\Query\GetMessagesQuery;
use App\Repository\MateMessageRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

final readonly class MessagesQueryHandler
{
    public function __construct(private MateMessageRepository $mateMessageRepository)
    {
    }

    #[AsMessageHandler]
    public function getMateMessages(GetMessagesQuery $query): array
    {
        return $this->mateMessageRepository->findBy(['toId' => $query->mate->getId()->toString()]);
    }
}
