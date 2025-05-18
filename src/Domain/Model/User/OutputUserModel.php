<?php

namespace App\Domain\Model\User;

class OutputUserModel
{
    public function __construct(
        public string $email,
        public string $firstName,
        public array  $roles,
        public bool   $isActive,
    ) {
    }
}
