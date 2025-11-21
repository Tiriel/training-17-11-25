<?php

namespace App\Matching\Strategy;

use App\Entity\User;
use App\Matching\Strategy\MatchingStrategyInterface;
use App\Repository\ConferenceRepository;

class LocationBasedStrategy implements MatchingStrategyInterface
{
    public function __construct(
        protected readonly ConferenceRepository $repository,
    ) {}

    public function match(User $user): iterable
    {
        // TODO: Implement match() method.
        return [];
    }

    public static function getName(): string
    {
        return 'location';
    }
}
