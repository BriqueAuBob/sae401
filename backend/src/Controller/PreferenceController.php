<?php

namespace App\Controller;

use App\Dto\UpdatePreferenceDto;
use App\Entity\Preference;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/users/@me/preferences')]
class PreferenceController extends AbstractController
{
    #[Route('', name: 'app_preferences')]
    public function index(): JsonResponse
    {
        return $this->json($this->getUser()->getPreferences());
    }

    #[Route('/{preference}', 'app_preferences_update', methods: ['PUT'])]
    public function update(
        Preference                               $preference,
        #[MapRequestPayload] UpdatePreferenceDto $updatePreferenceDto,
        EntityManagerInterface                   $entityManager
    ): \Symfony\Component\HttpKernel\Exception\NotFoundHttpException|JsonResponse
    {
        if ($preference->getUser()->getUserIdentifier() !== $this->getUser()->getUserIdentifier()) {
            return $this->createNotFoundException();
        }

        $preference->setPvalue($updatePreferenceDto->pvalue);
        $entityManager->persist($preference);
        $entityManager->flush();

        return $this->json([
            'message' => 'La préférence a bien été modifiée',
            'preference' => [
                'id' => $preference->getId(),
                'pkey' => $preference->getPkey(),
                'pvalue' => $preference->getPvalue(),
                'ptype' => $preference->getPtype()
            ],
            'status' => 'success'
        ]);
    }
}
