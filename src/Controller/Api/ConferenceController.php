<?php

namespace App\Controller\Api;

use App\Repository\ConferenceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ConferenceController extends AbstractController
{
    #[Route('/api/conference', name: 'app_api_conference')]
    public function index(Request $request, ConferenceRepository $repository): JsonResponse
    {
        $limit = 20;
        $page = $request->query->get('page', 1);
        $conferences = $repository->findBy([], [], $limit, ($page - 1) * $limit);

        return $this->json($conferences, Response::HTTP_OK, context: ['groups' => ['Volunteering']]);
    }
}
