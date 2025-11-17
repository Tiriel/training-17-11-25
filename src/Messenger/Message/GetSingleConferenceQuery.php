<?php

namespace App\Messenger\Message;

final class GetSingleConferenceQuery
{
    public function __construct(
        public int $conferenceId,
    ) {}
}
