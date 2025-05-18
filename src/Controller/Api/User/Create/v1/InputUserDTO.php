<?php

namespace App\Controller\Api\User\Create\v1;

use App\Controller\Validator\UniqueEmail;
use Symfony\Component\Validator\Constraints as Assert;

class InputUserDTO
{
    public function __construct(
        #[Assert\NotBlank]
        #[UniqueEmail]
        public readonly string $email,
        #[Assert\NotBlank]
        public readonly string $firstName,
        #[Assert\NotBlank]
        public readonly string $password,
        #[Assert\NotBlank]
        public readonly string $role,
    ) {
    }
}
