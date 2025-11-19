<?php

namespace App\Controller;

use App\Messenger\Message\GetSingleConferenceQuery;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Twig\Environment;

#[AsController]
class ShowConferenceController
{
    use HandleTrait;
    public function __construct(
        MessageBusInterface $messageBus,
        private readonly SerializerInterface $serializer,
        private readonly Environment $twig,
    ) {
        $this->messageBus = $messageBus;
    }

    #[Route('/conference/{id}', name: 'app_conference_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function __invoke(Request $request, int $id): Response
    {
        $conference = $this->handle(new GetSingleConferenceQuery($id));
        $response = (new Response())
            ->setEtag(md5($this->serializer->serialize($conference, 'json')));

        if ($response->isNotModified($request)) {
            return $response;
        }

        return $response->setContent($this->twig->render('conference/show.html.twig', [
            'conference' => $conference,
        ]));
    }
}
