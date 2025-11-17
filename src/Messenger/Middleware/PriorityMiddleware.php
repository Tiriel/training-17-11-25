<?php

namespace App\Messenger\Middleware;

use App\Messenger\Stamp\PriorityStamp;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;
use Symfony\Component\Messenger\Stamp\TransportNamesStamp;

final class PriorityMiddleware implements MiddlewareInterface
{
    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        if (null !== $envelope->last(PriorityStamp::class)) {
            $stamp = $envelope->last(PriorityStamp::class);

            $transport = $stamp->priority->getTransport();
            $envelope = $envelope->with(new TransportNamesStamp([$transport]));
        }

        return $stack->next()->handle($envelope, $stack);
    }
}
