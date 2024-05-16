<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class CreateUserDto
{
    public function __construct(
        #[Assert\NotBlank(message: "L'email ne doit pas être vide.")]
        #[Assert\Email(message: "L'email est invalide.")]
        public string $email,
        #[Assert\NotBlank]
        #[Assert\PasswordStrength([
            'minScore' => 1
        ], message: "Le mot de passe est trop faible. Utilisez un mot de passe plus robuste.")]
        public string $password,
        #[Assert\NotBlank(message: "La confirmation de mot de passe est invalide")]
        #[Assert\EqualTo(propertyPath: 'password', message: "Les mots de passe doivent être identiques")]
        public string $password_confirm,
        #[Assert\NotBlank]
        #[Assert\Length(
            min: 2,
            max: 50,
            minMessage: 'Le nom d\'utilisateur est trop court.',
            maxMessage: 'Le nom d\'utilisateur est trop long.',
        )]
        public string $username,
    )
    {
    }
}