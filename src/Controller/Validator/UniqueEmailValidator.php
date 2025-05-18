<?php

namespace App\Controller\Validator;

use AllowDynamicProperties;
use App\Domain\Service\UserService;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

#[AllowDynamicProperties]
class UniqueEmailValidator extends ConstraintValidator
{
    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    /**
     * @param string $value
     * @param Constraint $constraint
     * @return void
     */
    public function validate($value, Constraint $constraint): void
    {
        /** @var UniqueEmail $constraint */

        if (null === $value || '' === $value) {
            return;
        }

        if (!$this->service->findUserByEmail($value)) {
            return;
        }

        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value)
            ->addViolation();
    }
}
