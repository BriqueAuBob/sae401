<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class UpdateUserDto
{
    public function __construct(
        #[Assert\Email(message: "L'email est invalide.")]
        public string $email = '',
        public string $password = '',
        #[Assert\EqualTo(propertyPath: 'password', message: "Les mots de passe doivent être identiques")]
        public string $password_confirm = '',
        #[Assert\Length(
            min: 2,
            max: 50,
            minMessage: 'Le nom d\'utilisateur est trop court.',
            maxMessage: 'Le nom d\'utilisateur est trop long.',
        )]
        public string $username = '',
    )
    {
    }
}