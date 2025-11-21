<?php

namespace App\Search;

use App\Entity\Organization;
use App\Entity\User;
use App\Repository\ConferenceRepository;
use Symfony\Bundle\SecurityBundle\Security;

class DatabaseConferenceSearchConfigurator
{
    public function __construct(
        private readonly ConferenceRepository $repository,
        private readonly int $limit,
        private readonly Security $security,
    ) {}

    public function configure(DatabaseConferenceSearch $search): void
    {
        $user = $this->security->getUser();

        if ($user instanceof User) {
            $org = $user->getOrganizations()->first();
            $org = $org instanceof Organization ? $org : null;

            $search
                ->setOrganization($org)
                ->setRepository($this->repository)
                ->setLimit($this->limit)
            ;
        }
    }
}
