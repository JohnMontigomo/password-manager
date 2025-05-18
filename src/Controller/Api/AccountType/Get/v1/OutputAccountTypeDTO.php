<?php

namespace App\Controller\Api\AccountType\Get\v1;

use App\Controller\DTO\OutputDTOInterface;

class OutputAccountTypeDTO implements OutputDTOInterface
{
    public function __construct(
        public readonly string $id,
        public readonly string $title,
        public readonly array  $accountIdArray
    ) {
    }
}
