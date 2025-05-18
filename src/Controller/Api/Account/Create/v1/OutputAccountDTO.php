<?php

namespace App\Controller\Api\Account\Create\v1;

use App\Controller\DTO\OutputDTOInterface;

class OutputAccountDTO implements OutputDTOInterface
{
    public function __construct(
        public readonly string $id,
    ) {
    }
}
