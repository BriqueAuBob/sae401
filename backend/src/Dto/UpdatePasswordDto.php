<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class UpdatePasswordDto
{
    public function __construct(
        #[Assert\NotBlank(message: "Le mot de passe est invalide")]
        public string $password,
        #[Assert\NotBlank(message: "La confirmation de mot de passe est invalide")]
        #[Assert\EqualTo(propertyPath: 'password', message: "Les mots de passe doivent être identiques")]
        public string $confirm_password
    ) {}
}