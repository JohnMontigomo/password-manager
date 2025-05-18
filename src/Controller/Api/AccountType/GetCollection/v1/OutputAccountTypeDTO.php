<?php

namespace App\Controller\Api\AccountType\GetCollection\v1;

class OutputAccountTypeDTO
{
    public function __construct(
        public readonly string $id,
        public readonly string $title,
        public readonly array  $accountIdArray
    ) {
    }
}
