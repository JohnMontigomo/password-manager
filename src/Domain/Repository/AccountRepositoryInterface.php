<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Account;

interface AccountRepositoryInterface
{
    public function create(Account $account): int;

    public function getAccountById(int $id): ?Account;

    public function remove(Account $account): void;

    public function getAccountIdByAccountTypeId(int $id): array;
}
