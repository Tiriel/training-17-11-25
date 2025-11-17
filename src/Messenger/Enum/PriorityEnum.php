<?php

namespace App\Messenger\Enum;

enum PriorityEnum: string
{
    case Low = 'low';
    case High = 'high';

    public function getTransport(): string
    {
        return match ($this) {
            self::Low => 'low_priority',
            self::High => 'high_priority',
        };
    }
}
