<?php

namespace App\Controller\Api\Account\Delete\v1;

use App\Application\Security\AuthService;
use App\Controller\Exception\AccessDeniedException;
use App\Domain\Entity\Account;
use App\Domain\Service\AccountService;
use Symfony\Component\HttpFoundation\Request;

class Handler
{
    public function __construct(
        private readonly AccountService $accountService,
        private readonly AuthService    $authService,
    ) {
    }

    /**
     * @param Account|null $account
     * @param Request $request
     * @return bool
     * @throws AccessDeniedException
     */
    public function delete(?Account $account, Request $request): bool
    {
        if ($account === null) {
            return false;
        }

        $this->authService->checkAccessByToken($account, $request);

        $this->accountService->remove($account);

        return true;
    }
}


