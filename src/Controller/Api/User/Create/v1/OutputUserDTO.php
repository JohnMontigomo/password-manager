<?php

namespace App\Controller\Api\User\Create\v1;

use App\Controller\DTO\OutputDTOInterface;

class OutputUserDTO implements OutputDTOInterface
{
    public function __construct(
        public readonly string $id,
    ) {
    }
}
