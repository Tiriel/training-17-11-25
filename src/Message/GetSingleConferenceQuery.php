<?php

namespace App\Message;

final class GetSingleConferenceQuery
{
    public function __construct(
        public int $conferenceId,
    ) {}
}
