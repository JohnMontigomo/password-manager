<?php

namespace App\Controller\Api\AccountType\Create\v1;

use Symfony\Component\Validator\Constraints as Assert;

class InputAccountTypeDTO
{
    public function __construct(
        #[Assert\NotBlank]
        public readonly string $title,
    ) {
    }
}
