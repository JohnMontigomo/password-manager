<?php

namespace App\Domain\Model\Account;

class OutputAccountModel
{
    public function __construct(
        public string $title,
        public string $login,
        public string $password,
    ) {
    }
}
