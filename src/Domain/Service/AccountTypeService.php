<?php

namespace App\Domain\Service;

use App\Domain\Entity\AccountType;
use App\Domain\Model\AccountType\CreateAccountTypeModel;
use App\Domain\Repository\AccountTypeRepositoryInterface;

class AccountTypeService
{
    public function __construct(
        private readonly AccountTypeRepositoryInterface $accountTypeRepository
    ) {
    }

    public function create(CreateAccountTypeModel $inputAccountTypeModel): int
    {
        $accountType = new AccountType();
        $accountType->setTitle($inputAccountTypeModel->title);
        $accountType->setUser($inputAccountTypeModel->user);

        return $this->accountTypeRepository->create($accountType);
    }

    public function getAccountTypeById(int $id): ?AccountType
    {
        return  $this->accountTypeRepository->getAccountTypeById($id);
    }

    public function remove(AccountType $accountType): void
    {
        $this->accountTypeRepository->remove($accountType);
    }
}
