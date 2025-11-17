<?php

namespace App\Messenger\Stamp;

use App\Messenger\Enum\PriorityEnum;
use Symfony\Component\Messenger\Stamp\StampInterface;

class PriorityStamp implements StampInterface
{
    public function __construct(
        public PriorityEnum $priority,
    ) {}
}
