<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Account;
use App\Domain\Model\Account\UpdateAccountModel;
use App\Domain\Repository\AccountRepositoryInterface;

class AccountRepository extends AbstractRepository implements AccountRepositoryInterface
{
    public function create(Account $account): int
    {
        return $this->store($account);
    }

    public function getAccountById(int $id): ?Account
    {
        return $this->entityManager->getRepository(Account::class)->findOneBy(
            ['id' => $id]
        );
    }

    public function remove(Account $account): void
    {
        $this->entityManager->remove($account);
        $this->flush();
    }

    public function getAccountIdByAccountTypeId(int $id): array
    {
        return $this->entityManager->getRepository(Account::class)->findBy(
            ['accountType' => $id]
        );
    }

    public function update(Account $account, UpdateAccountModel $updateAccountModel): void
    {
        if ($updateAccountModel->title) {
            $account->setTitle($updateAccountModel->title);
        }

        if ($updateAccountModel->login) {
            $account->setLogin($updateAccountModel->login);
        }

        if ($updateAccountModel->password) {
            $account->setPassword($updateAccountModel->password);
        }

        if ($updateAccountModel->accountTypeId) {
            $account->setAccountType($updateAccountModel->accountTypeId);
        }

        $this->flush();
    }
}
