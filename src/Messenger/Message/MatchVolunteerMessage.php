<?php

namespace App\Messenger\Message;

final class MatchVolunteerMessage
{
    public function __construct(
        public int $userId,
    ) {}
}
