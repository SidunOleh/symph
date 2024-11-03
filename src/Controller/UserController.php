<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Request\User\DeleteRequest;
use App\Request\User\ShowRequest;
use App\Request\User\StoreRequest;
use App\Request\User\UpdateRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/v1/api/users', name: 'v1_api_users')]
class UserController extends AbstractController
{
    public function __construct(
        private UserRepository $userRepository,
        private EntityManagerInterface $entityManager    
    )
    {
        
    }

    #[Route(methods: 'GET', name: 'show')]
    public function show(ShowRequest $request): JsonResponse
    {
        $this->denyAccessUnlessGranted('user_show', $request->id);

        $user = $this->userRepository->find($request->id);

        if ($user === null) {
            return $this->response(['error' => 'Not found.'], JsonResponse::HTTP_NOT_FOUND);
        }

        $data = [];
        $data['login'] = $user->getLogin();
        $data['phone'] = $user->getPhone();
        $data['pass'] = $user->getPass();

        return $this->response($data);
    }

    #[Route(methods: 'POST', name: 'store')]
    public function store(StoreRequest $request): JsonResponse
    {
        $this->denyAccessUnlessGranted('user_store');
        
        $user = new User;
        $user->setLogin($request->login);
        $user->setPhone($request->phone);
        $user->setPass($request->pass);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $data = [];
        $data['id'] = $user->getId();
        $data['login'] = $user->getLogin();
        $data['phone'] = $user->getPhone();
        $data['pass'] = $user->getPass();

        return $this->response($data);
    }

    #[Route(methods: 'PUT', name: 'update')]
    public function update(UpdateRequest $request): JsonResponse
    {
        $this->denyAccessUnlessGranted('user_update', $request->id);

        $user = $this->userRepository->find($request->id);

        if ($user === null) {
            return $this->response(['error' => 'Not found.'], JsonResponse::HTTP_NOT_FOUND);
        }

        $user->setLogin($request->login);
        $user->setPhone($request->phone);
        $user->setPass($request->pass);

        $this->entityManager->flush();

        return $this->response(['id' => $user->getId(),]);
    }

    #[Route(methods: 'DELETE', name: 'delete')]
    public function delete(DeleteRequest $request): JsonResponse
    {
        $this->denyAccessUnlessGranted('user_delete', $request->id);

        $user = $this->userRepository->find($request->id);

        if ($user === null) {
            return $this->response(['error' => 'Not found.'], JsonResponse::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($user);
        $this->entityManager->flush();

        return $this->response();
    }

    public function response(?array $data = null, int $status = JsonResponse::HTTP_OK): JsonResponse
    {
        return new JsonResponse($data, $status);
    }
}
