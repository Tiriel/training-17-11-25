<?php

namespace App\Matching\Strategy;

use App\Entity\User;
use App\Repository\ConferenceRepository;
use Tiriel\MatchingBundle\Interface\MatchableUserInterface;
use Tiriel\MatchingBundle\Matching\Strategy\AbstractMatchingStrategy;

class SkillMatchingStrategy extends AbstractMatchingStrategy
{
    public function __construct(ConferenceRepository $repository)
    {
        $this->repository = $repository;
    }

    public function match(User|MatchableUserInterface $user): iterable
    {
        return $this->repository->findForSkills($user);
    }

    protected function getBaseEntityName(): string
    {
        return 'conference';
    }

    protected function getMatchableName(): string
    {
        return 'skill';
    }

    protected function getMatchablesFromUser(MatchableUserInterface $user): iterable
    {
        /** @var User $user */
        return $user->getVolunteerProfile()->getSkills()->toArray();
    }
}
