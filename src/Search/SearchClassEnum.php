<?php

namespace App\Search;

use App\Search\Client\ConferenceApiClient;

enum SearchClassEnum: string
{
    case Database = 'database';
    case Api = 'api';

    public function getClass(): string
    {
        return match ($this) {
            self::Database => DatabaseConferenceSearch::class,
            self::Api => ConferenceApiClient::class,
        };
    }
}
