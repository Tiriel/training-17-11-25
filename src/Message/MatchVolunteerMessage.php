<?php

namespace App\Message;

final class MatchVolunteerMessage
{
    public function __construct(
        public int $userId,
    ) {}
}
