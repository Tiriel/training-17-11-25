<?php

namespace App\Matching\Strategy;

use App\Entity\User;
use App\Repository\ConferenceRepository;
use Tiriel\MatchingBundle\Interface\MatchableUserInterface;
use Tiriel\MatchingBundle\Matching\Strategy\AbstractMatchingStrategy;

class LocationMatchingStrategy extends AbstractMatchingStrategy
{
    public function __construct(ConferenceRepository $repository)
    {
        $this->repository = $repository;
    }

    public static function getName(): string
    {
        return 'location';
    }

    protected function getBaseEntityName(): string
    {
        return '';
    }

    protected function getMatchableName(): string
    {
        return '';
    }

    protected function getMatchablesFromUser(MatchableUserInterface $user): iterable
    {
        return [];
    }
}
