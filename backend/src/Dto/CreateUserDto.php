<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class CreateUserDto
{
    public function __construct(
        #[Assert\NotBlank(message: "L'email ne doit pas être vide.")]
        public string $email,
        #[Assert\NotBlank]
        public string $password,
        #[Assert\NotBlank]
        public string $username,
    ) {}
}