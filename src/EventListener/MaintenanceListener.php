<?php

namespace App\EventListener;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment;

final class MaintenanceListener
{
    public function __construct(
        private readonly Environment $twig,
        #[Autowire(param: 'env(bool:APP_MAINTENANCE)')]
        private readonly bool $isMaintenance,
    ) {}

    #[AsEventListener(event: KernelEvents::REQUEST, priority: 9001)]
    public function onKernelRequest(RequestEvent $event): void
    {
        if ($this->isMaintenance && $event->isMainRequest()) {
            $response = (new Response())
                ->setContent($this->twig->render('maintenance.html.twig'))
                ->setStatusCode(200);

            $event->setResponse($response);
        }
    }
}
