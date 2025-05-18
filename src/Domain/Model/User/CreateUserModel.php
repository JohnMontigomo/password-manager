<?php

namespace App\Domain\Model\User;

use App\Domain\Enum\UserRoleEnum;

class CreateUserModel
{
    public function __construct(
        public string $email,
        public string $firstName,
        public UserRoleEnum $role,
        public string $password,
        public bool $isActive,
    ) {
    }
}
