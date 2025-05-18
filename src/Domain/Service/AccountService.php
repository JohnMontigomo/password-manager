<?php

namespace App\Domain\Service;

use App\Domain\Entity\Account;
use App\Domain\Model\Account\CreateAccountModel;
use App\Domain\Model\Account\UpdateAccountModel;
use App\Domain\Repository\AccountRepositoryInterface;

class AccountService
{
    public function __construct(
        private readonly AccountRepositoryInterface $accountRepository
    ) {
    }

    public function create(CreateAccountModel $inputAccountModel): int
    {
        $account = new Account();
        $account->setTitle($inputAccountModel->title);
        $account->setLogin($inputAccountModel->login);
        $account->setPassword($inputAccountModel->password);
        $account->setAccountType($inputAccountModel->accountType);
        $account->setUser($inputAccountModel->user);

        return $this->accountRepository->create($account);
    }

    public function getAccountById(int $id): ?Account
    {
        return  $this->accountRepository->getAccountById($id);
    }

    public function remove(Account $account): void
    {
        $this->accountRepository->remove($account);
    }

    public function getAccountIdByAccountTypeId(int $id): array
    {
        $accountObjectArray =  $this->accountRepository->getAccountIdByAccountTypeId($id);
        $accountIdArray = [];

        foreach ($accountObjectArray as  $account) {
            $accountIdArray[] = $account->getId();
        }

        return  $accountIdArray;
    }

    public function update(Account $account, UpdateAccountModel $updateAccountModel): void
    {
        $this->accountRepository->update($account, $updateAccountModel);
    }
}
