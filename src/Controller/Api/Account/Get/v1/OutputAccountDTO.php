<?php

namespace App\Controller\Api\Account\Get\v1;

use App\Controller\DTO\OutputDTOInterface;

class OutputAccountDTO implements OutputDTOInterface
{
    public function __construct(
        public readonly string   $id,
        public readonly string   $title,
        public readonly ?string  $accountTypeId,
        public readonly ?string  $accountTypeTile,
    ) {
    }
}
