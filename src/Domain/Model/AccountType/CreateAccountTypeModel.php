<?php

namespace App\Domain\Model\AccountType;

use App\Domain\Entity\User;

class CreateAccountTypeModel
{
    public function __construct(
        public string $title,
        public User   $user,
    ) {
    }
}
