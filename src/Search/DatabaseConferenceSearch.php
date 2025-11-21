<?php

namespace App\Search;

use App\Entity\Organization;
use App\Repository\ConferenceRepository;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;

#[Autoconfigure(configurator: ['@'.DatabaseConferenceSearchConfigurator::class, 'configure'])]
class DatabaseConferenceSearch implements ConferenceSearchInterface
{
    private ?Organization $organization = null;

    private ?ConferenceRepository $repository = null;

    private int $limit = 0;

    public function setOrganization(?Organization $organization): DatabaseConferenceSearch
    {
        $this->organization = $organization;

        return $this;
    }

    public function setRepository(?ConferenceRepository $repository): DatabaseConferenceSearch
    {
        $this->repository = $repository;

        return $this;
    }

    public function setLimit(int $limit): DatabaseConferenceSearch
    {
        $this->limit = $limit;

        return $this;
    }

    public function search(?string $name): array
    {
        if (null === $name) {
            $criteria = $this->getCriteria();

            return $this->repository->findBy($criteria, [], $this->limit);
        }

        return $this->repository->findLikeName($name, $this->limit, $this->organization);
    }

    private function getCriteria(): array
    {
        $criteria = [];

        if ($this->organization instanceof Organization) {
            $criteria['organization'] = $this->organization;
        }

        return $criteria;
    }
}
