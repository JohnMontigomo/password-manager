<?php

namespace App\Domain\Model\Account;

use App\Domain\Entity\AccountType;

class UpdateAccountModel
{
    public function __construct(
        public readonly ?string $title,
        public readonly ?string $login,
        public readonly ?string $password,
        public readonly ?AccountType $accountTypeId,
    ) {
    }
}
