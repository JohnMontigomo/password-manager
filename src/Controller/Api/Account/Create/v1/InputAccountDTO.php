<?php

namespace App\Controller\Api\Account\Create\v1;

use Symfony\Component\Validator\Constraints as Assert;

class InputAccountDTO
{
    public function __construct(
        #[Assert\NotBlank]
        public readonly string  $title,
        #[Assert\NotBlank]
        public readonly string  $login,

        public readonly ?string $password,
        #[Assert\NotBlank]
        public readonly ?string $accountTypeId,
        #[Assert\NotBlank]
        public readonly string  $userId,
    ) {
    }
}
