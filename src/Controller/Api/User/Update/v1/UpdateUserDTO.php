<?php

namespace App\Controller\Api\User\Update\v1;

use App\Controller\Validator\UniqueEmail;

class UpdateUserDTO
{
    public function __construct(
        #[UniqueEmail]
        public readonly ?string $email,
        public readonly ?string $firstName,
        public readonly ?string $password,
    ) {
    }
}
