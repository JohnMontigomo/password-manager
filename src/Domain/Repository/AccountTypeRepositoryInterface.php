<?php

namespace App\Domain\Repository;

use App\Domain\Entity\AccountType;

interface AccountTypeRepositoryInterface
{
    public function create(AccountType $accountType): int;

    public function getAccountTypeById(int $id): ?AccountType;

    public function remove(AccountType $accountType ): void;
}
