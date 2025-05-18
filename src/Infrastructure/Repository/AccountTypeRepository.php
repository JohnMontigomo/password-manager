<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\AccountType;
use App\Domain\Repository\AccountTypeRepositoryInterface;

class AccountTypeRepository extends AbstractRepository implements AccountTypeRepositoryInterface
{
    public function create(AccountType $accountType): int
    {
        return $this->store($accountType);
    }

    public function getAccountTypeById(int $id): ?AccountType
    {
        return $this->entityManager->getRepository(AccountType::class)->findOneBy(
            ['id' => $id]
        );
    }

    public function remove(AccountType $accountType ): void
    {
        $this->entityManager->remove($accountType);
        $this->flush();
    }
}
