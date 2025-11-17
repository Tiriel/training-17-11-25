<?php

namespace App\Message;

use Symfony\Component\Messenger\Attribute\AsMessage;

#[AsMessage(transport: 'async')]
final class SendEmailMessage
{
    public function __construct(
        public int $userId,
    ) {}
}
