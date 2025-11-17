<?php

namespace App\Matching;

use App\Entity\User;
use App\Matching\Strategy\LocationBasedStrategy;
use App\Matching\Strategy\MatchingStrategyInterface;
use App\Matching\Strategy\SkillBasedStrategy;
use App\Matching\Strategy\TagBasedStrategy;

class Matcher implements MatchingStrategyInterface
{
    public function __construct(
        private readonly TagBasedStrategy $tagBasedStrategy,
        private readonly SkillBasedStrategy $skillBasedStrategy,
        private readonly LocationBasedStrategy $locationBasedStrategy
    ) {}

    public function match(User $user, ?string $strategy = null): iterable
    {
        $strategy = match ($strategy) {
            'tag' => $this->tagBasedStrategy,
            'skill' => $this->skillBasedStrategy,
            'location' => $this->locationBasedStrategy,
            default => throw new \InvalidArgumentException(),
        };

        return $strategy->match($user);
    }

    public static function getName(): string
    {
        return 'matcher';
    }
}
