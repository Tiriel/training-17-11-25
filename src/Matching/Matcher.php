<?php

namespace App\Matching;

use App\Entity\User;
use App\Matching\Strategy\MatchingStrategyInterface;
use Symfony\Component\Cache\CacheItem;
use Symfony\Component\DependencyInjection\Attribute\AutowireLocator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

class Matcher implements MatchingStrategyInterface
{
    public function __construct(
        /** @var ContainerInterface<string, MatchingStrategyInterface> $strategies */
        #[AutowireLocator('app.matching_strategies', defaultIndexMethod: 'getName')]
        private ContainerInterface $strategies,
        private readonly TagAwareCacheInterface $cache,
        private readonly SluggerInterface $slugger,
    ) {}

    public function match(User $user, ?string $strategy = null): iterable
    {
        return $this->cache->get(
            $this->slugger->slug($user->getUserIdentifier()),
            function (CacheItem $item) use ($user, $strategy) {
                $result = $this->strategies->get($strategy)->match($user, $item);
                $item
                    ->set($result)
                    ->tag(['matchings'])
                    ->expiresAfter(84600);

                return $item->get();
            }
        );
    }

    public static function getName(): string
    {
        return 'matcher';
    }
}
