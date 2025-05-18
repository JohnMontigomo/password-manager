<?php

namespace App\Controller\Api\Account\Update;

class UpdateAccountDTO
{
    public function __construct(
        public readonly ?string $title,
        public readonly ?string $login,
        public readonly ?string $password,
        public readonly ?string $accountTypeId,
    ) {
    }
}
