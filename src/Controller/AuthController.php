<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Request\Auth\LoginRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

#[Route('/v1/api', name: 'v1_api_auth')]
class AuthController extends AbstractController
{
    #[Route('/login', name: 'login')]
    public function login(
        LoginRequest $request, 
        UserRepository $userRepository,
        JWTTokenManagerInterface $jwtManager
    ): JsonResponse
    {
        $user = $userRepository->findByCredentials(
            $request->login, 
            $request->pass
        );

        if ($user === null) {
            return new JsonResponse(['error' => 'Invalid credentials.'], 401);
        }

        $token = $jwtManager->createFromPayload($user, [
            'type' => ['testUser', 'testAdmin',][rand(0, 1)],
        ]);

        return new JsonResponse(['token' => $token,]);
    }
}
