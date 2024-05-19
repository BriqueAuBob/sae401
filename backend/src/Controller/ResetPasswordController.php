<?php

namespace App\Controller;

use App\Dto\UpdatePasswordDto;
use App\Entity\User;
use App\Form\ChangePasswordFormType;
use App\Form\ResetPasswordRequestFormType;
use App\Repository\UserRepository;
use App\Services\FrontEndUrlGeneratorService;
use App\Services\MailerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use SymfonyCasts\Bundle\ResetPassword\Controller\ResetPasswordControllerTrait;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;
use SymfonyCasts\Bundle\ResetPassword\Exception\TooManyPasswordRequestsException;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;

#[Route('/api/auth/reset-password')]
class ResetPasswordController extends AbstractController
{
    use ResetPasswordControllerTrait;

    public function __construct(
        private ResetPasswordHelperInterface $resetPasswordHelper,
        private EntityManagerInterface $entityManager,
        private UserRepository $userRepository
    ) {
    }

    /**
     * Display & process form to request a password reset.
     * @throws ResetPasswordExceptionInterface
     * @throws \Exception
     */
    #[Route('', name: 'app_forgot_password_request', methods: ['POST'])]
    public function request(Request $request, MailerService $mailer, FrontEndUrlGeneratorService $frontEndUrlGeneratorService,): Response
    {
        $email = $request->getPayload()->get('email');

        if (!$email)
            return $this->json(['message' => 'Email manquant'], Response::HTTP_BAD_REQUEST);

        $user = $this->userRepository->findOneBy(['email' => $email]);

        if ($user) {
            try {
                $token = $this->resetPasswordHelper->generateResetToken($user, 3600);
                $resetLink = $frontEndUrlGeneratorService->generate('/auth/reset-password/' . $token->getToken());
                $mailer->sendEmail(
                    $email,
                    'Réinitialisation de votre mot de passe',
                    $this->renderView('emails/reset_password.html.twig', ['user' => $user, 'resetLink' => $resetLink])
                );
            } catch (TooManyPasswordRequestsException $e) {
                return $this->json([
                    'message' => "Trop de tentatives de réinitialisation de mot de passe. Réessayez plus tard.",
                    'error' => true
                ], 429);
            }
        }

        return $this->json([
            'message' => 'L\'email de réinitialisation a été envoyé si un compte est associé à cet email.'
        ]);
    }

    /**
     * Validates and process the reset URL that the user clicked in their email.
     * @throws \Exception
     */
    #[Route('/{token}', name: 'app_reset_password', methods: ['POST'])]
    public function reset(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        ?string $token = null,
        #[MapRequestPayload] UpdatePasswordDto $dto
    ): Response
    {
        if (null === $token) {
            throw $this->createNotFoundException('No reset password token found in the URL or in the session.');
        }

        try {
            /** @var User $user */
            $user = $this->resetPasswordHelper->validateTokenAndFetchUser($token);
        } catch (ResetPasswordExceptionInterface $e) {
            throw new \Exception('Une erreur est survenue.');
        }

        $this->resetPasswordHelper->removeResetRequest($token);

        $encodedPassword = $passwordHasher->hashPassword(
            $user,
            $dto->password
        );

        $user->setPassword($encodedPassword);
        $this->entityManager->flush();

        return $this->json([
            'message' => 'Le mot de passe a bien été modifié.',
            'status' => 'success'
        ]);
    }
}
