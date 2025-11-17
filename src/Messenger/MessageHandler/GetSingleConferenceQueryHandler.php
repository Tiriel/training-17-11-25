<?php

namespace App\Messenger\MessageHandler;

use App\Entity\Conference;
use App\Messenger\Message\GetSingleConferenceQuery;
use App\Repository\ConferenceRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class GetSingleConferenceQueryHandler
{
    public function __construct(
        private readonly ConferenceRepository $conferenceRepository,
    ) {}

    public function __invoke(GetSingleConferenceQuery $message): ?Conference
    {
        return $this->conferenceRepository->find($message->conferenceId);
    }
}
