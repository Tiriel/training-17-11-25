<?php

namespace App\Client;

use Symfony\Component\HttpClient\CachingHttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ExternalVolunteerApiClient
{
    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client,)
    {
        $this->client = new CachingHttpClient($client);
    }

    public function getVolunteerOpportunities(array $tags): iterable
    {

        return $this->client->request(
            Request::METHOD_GET,
            '/search',
            ['query' => ['tags' => implode(',', $tags)]]
        )->toArray();
    }
}
