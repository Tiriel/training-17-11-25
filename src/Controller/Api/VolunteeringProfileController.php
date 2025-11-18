<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Repository\VolunteerProfileRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

final class VolunteeringProfileController extends AbstractController
{
    #[Route('/api/volunteering/profile', name: 'app_api_volunteering_profile')]
    public function index(Request $request, VolunteerProfileRepository $repository): JsonResponse
    {
        $limit = 20;
        $page = $request->query->get('page', 1);
        $profiles = $repository->findBy([], [], $limit, ($page - 1) * $limit);

        return $this->json($profiles, context: [
            AbstractNormalizer::GROUPS => ['profile:read'],

        ]);
    }

    #[IsGranted('is_granted("ROLE_ADMIN") or forUser == user')]
    #[Route('/api/volunteering/profile/{email:forUser}', name: 'app_api_volunteering_profile_myprofile', requirements: ['email' => Requirement::CATCH_ALL])]
    public function myProfile(User $forUser): JsonResponse
    {
        return $this->json($forUser->getVolunteerProfile(), context: ['groups' => ['profile:read']]);
    }
}
