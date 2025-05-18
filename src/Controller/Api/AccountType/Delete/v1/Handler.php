<?php

namespace App\Controller\Api\AccountType\Delete\v1;

use App\Application\Security\AuthService;
use App\Controller\Exception\AccessDeniedException;
use App\Controller\Exception\AccountTypeHasAccountException;
use App\Domain\Entity\AccountType;
use App\Domain\Service\AccountService;
use App\Domain\Service\AccountTypeService;
use Symfony\Component\HttpFoundation\Request;

class Handler
{
    public function __construct(
        private readonly AccountService     $accountService,
        private readonly AccountTypeService $accountTypeService,
        private readonly AuthService        $authService,
    ) {
    }

    /**
     * @param AccountType|null $accountType
     * @param Request $request
     * @return bool
     * @throws AccountTypeHasAccountException
     * @throws AccessDeniedException
     */
    public function delete(?AccountType $accountType, Request $request): bool
    {
        if ($accountType === null) {
            return false;
        }

        $this->authService->checkAccessByToken($accountType, $request);

        if (count($this->accountService->getAccountIdByAccountTypeId($accountType->getId())) > 0) {
            throw new AccountTypeHasAccountException();
        }

        $this->accountTypeService->remove($accountType);

        return true;
    }
}
