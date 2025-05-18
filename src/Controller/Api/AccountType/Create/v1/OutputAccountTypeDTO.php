<?php

namespace App\Controller\Api\AccountType\Create\v1;

use App\Controller\DTO\OutputDTOInterface;

class OutputAccountTypeDTO implements OutputDTOInterface
{
    public function __construct(
        public readonly string $id,
    ) {
    }
}
