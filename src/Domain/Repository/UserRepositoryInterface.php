<?php

namespace App\Domain\Repository;

use App\Domain\Entity\User;
use App\Domain\Model\User\UpdateUserModel;

interface UserRepositoryInterface
{
    public function create(User $user): int;

    public function findUserByEmail(string $email): ?User;

    public function createApiToken(User $user): string;

    public function findUserByApiToken(string $apiToken): ?User;

    public function update(User $user, UpdateUserModel $updateUserModel): void;
}
