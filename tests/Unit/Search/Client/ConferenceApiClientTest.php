<?php

namespace App\Tests\Unit\Search\Client;

use App\Search\Client\ConferenceApiClient;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Clock\DatePoint;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\JsonMockResponse;

class ConferenceApiClientTest extends TestCase
{
    public function testSearchMethodReturnsArray(): void
    {
        $res1 = new JsonMockResponse([
            ['name' => 'SymfonyLive 2025', 'startAt' => new DatePoint('28-03-2026')],
        ], ['http_code' => 200]);
        $apiClient = new ConferenceApiClient(new MockHttpClient($res1));

        $result = $apiClient->search('SymfonyLive');

        $this->assertIsArray($result);
    }
}
