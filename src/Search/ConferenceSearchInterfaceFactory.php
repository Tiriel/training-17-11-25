<?php

namespace App\Search;

use App\Search\Client\ConferenceApiClient;
use Symfony\Component\DependencyInjection\Attribute\Lazy;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ConferenceSearchInterfaceFactory
{
    public function __construct(
        private readonly HttpClientInterface $conferencesClient,
        #[Lazy]
        private readonly DatabaseConferenceSearch $databaseConferenceSearch,
    ) {}

    public function create(string $defaultSearch): ConferenceSearchInterface
    {
        $defaultSearch = SearchClassEnum::from($defaultSearch);

        return match ($defaultSearch) {
            SearchClassEnum::Database => $this->databaseConferenceSearch,
            SearchClassEnum::Api => new ConferenceApiClient($this->conferencesClient),
        };
    }
}
