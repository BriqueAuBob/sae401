<?php

namespace App\Controller;

use App\Dto\UpdateUserDto;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/users')]
class UserController extends AbstractController
{
    public function __construct(
        private readonly UserRepository $userRepository
    )
    {
    }

    #[Route('/@me', methods: ['PUT'])]
    public function update(#[MapRequestPayload] UpdateUserDto $updateUserDto, EntityManagerInterface $entityManager): JsonResponse
    {
        $user = $this->getUser();
        if ($updateUserDto->email) {
            $user->setEmail($updateUserDto->email);
        }
        if ($updateUserDto->password) {
            $user->setPassword($updateUserDto->password);
        }
        if ($updateUserDto->username) {
            $user->setUsername($updateUserDto->username);
        }
        $entityManager->flush();
        $entityManager->persist($user);

        return $this->json([
            'message' => 'Votre profil a été mis à jour avec succès.',
            'user' => $user,
            'status' => 'success'
        ]);
    }
}