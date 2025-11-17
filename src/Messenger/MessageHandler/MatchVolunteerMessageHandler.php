<?php

namespace App\Messenger\MessageHandler;

use App\Matching\Matcher;
use App\Messenger\Message\MatchVolunteerMessage;
use App\Repository\UserRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class MatchVolunteerMessageHandler
{
    public function __construct(
        private readonly UserRepository $repository,
        private readonly Matcher $matcher,
    ) {}

    public function __invoke(MatchVolunteerMessage $message): void
    {
        $user = $this->repository->find($message->userId);

        if (null === $user) {
            throw new \InvalidArgumentException('User not found');
        }

        $matches = [];
        foreach (['tag', 'skill', 'location'] as $value) {
            $matches[$value] = $this->matcher->match($user, $value);
        }

        dump($matches);
    }
}
