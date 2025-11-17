<?php

namespace App\Messenger\Middleware;

use App\Messenger\Stamp\LogStamp;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;
use Symfony\Component\Serializer\SerializerInterface;

final class LoggingMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly SerializerInterface $serializer,
    ) {}

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        if (null === $envelope->last(LogStamp::class)) {
            $envelope = $envelope->with(new LogStamp());
            $this->logger->info(sprintf(
                'New message dispatched : %s',
                $this->serializer->serialize($envelope->getMessage(), 'json')
            ));
        }

        return $stack->next()->handle($envelope, $stack);
    }
}
