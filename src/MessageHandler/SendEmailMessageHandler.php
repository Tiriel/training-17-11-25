<?php

namespace App\MessageHandler;

use App\Message\SendEmailMessage;
use App\Repository\UserRepository;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class SendEmailMessageHandler
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly MailerInterface $mailer,
    ) {}

    public function __invoke(SendEmailMessage $message): void
    {
        $user = $this->userRepository->find($message->userId);

        if (null === $user) {
            throw new \InvalidArgumentException('User not found');
        }

        // Create email
        dump(sprintf('Send email to user %d', $user->getId()));
    }
}
