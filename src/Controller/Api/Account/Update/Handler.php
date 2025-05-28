<?php

namespace App\Controller\Api\Account\Update;

use App\Application\Security\AuthService;
use App\Controller\Exception\AccessDeniedException;
use App\Domain\Entity\Account;
use App\Domain\Enum\MessageEnum;
use App\Domain\Factory\ModelFactory;
use App\Domain\Model\Account\UpdateAccountModel;
use App\Domain\Service\AccountService;
use App\Domain\Service\AccountTypeService;
use Symfony\Component\HttpFoundation\Request;

class Handler
{
    public function __construct(
        private readonly AuthService    $authService,
        private readonly ModelFactory   $modelFactory,
        private readonly AccountService $accountService,
        private readonly AccountTypeService $accountTypeService
    ) {
    }

    /**
     * @throws AccessDeniedException
     */
    public function update(Account $account, UpdateAccountDTO $updateAccountDTO, Request $request): string
    {
        $this->authService->checkAccessByToken($account, $request);

        $updateAccountModel = $this->modelFactory->makeModel(
            UpdateAccountModel::class,
            $updateAccountDTO->title ?? null,
            $updateAccountDTO->login ?? null,
            $updateAccountDTO->password ?? null,
            $this->accountTypeService->getAccountTypeById((int)$updateAccountDTO->accountTypeId) ?? null,
        );

        $this->accountService->update($account, $updateAccountModel);

        return MessageEnum::Ok->value;
    }
}
