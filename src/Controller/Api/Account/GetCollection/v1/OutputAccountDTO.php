<?php

namespace App\Controller\Api\Account\GetCollection\v1;

class OutputAccountDTO
{
    public function __construct(
        public readonly string   $id,
        public readonly string   $title,
        public readonly ?string  $accountTypeId,
        public readonly ?string  $accountTypeTile,
    ) {
    }
}
