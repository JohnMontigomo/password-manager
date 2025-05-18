<?php

namespace App\Domain\Model\User;

class UpdateUserModel
{
    public function __construct(
        public ?string $email,
        public ?string $firstName,
        public ?string $password,
    ) {
    }
}
