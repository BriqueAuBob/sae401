<?php

namespace App\Controller;

use App\Dto\CreateUserDto;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Serializer\SerializerInterface;

class ApiLoginController extends AbstractController
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly SerializerInterface $serializer
    )
    {
    }

    #[Route('/api/auth/register', name: 'api_register', methods: ['POST'])]
    public function register(#[MapRequestPayload] CreateUserDto $createUser, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        $userExists = $this->userRepository->findOneBy(['email' => $createUser->email]);
        if (null !== $userExists) {
            return $this->json([
                'message' => 'Cet email est déjà utilisé.',
            ], Response::HTTP_CONFLICT);
        }

        $user = new User();
        $user->setEmail($createUser->email);
        $user->setPassword($passwordHasher->hashPassword($user, $createUser->password));
        $user->setUsername($createUser->username);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $this->json([
            'user' => $user,
        ]);
    }

    #[Route('/api/users/@me', name: 'api_me', methods: ['GET'])]
    public function me(): JsonResponse
    {
        return $this->json([
            'user' => $this->getUser(),
        ]);
    }
}