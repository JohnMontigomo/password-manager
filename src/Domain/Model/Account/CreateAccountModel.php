<?php

namespace App\Domain\Model\Account;

use App\Domain\Entity\AccountType;
use App\Domain\Entity\User;

class CreateAccountModel
{
    public function __construct(
        public string      $title,
        public string      $login,
        public string      $password,
        public AccountType $accountType,
        public User        $user,
    ) {
    }
}
