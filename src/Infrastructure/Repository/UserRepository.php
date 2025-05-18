<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\User;
use App\Domain\Model\User\UpdateUserModel;
use App\Domain\Repository\UserRepositoryInterface;

class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    public function create(User $user): int
    {
        return $this->store($user);
    }

    public function findUserByEmail(string $email): ?User
    {
        return $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);
    }

    public function getUserById(int $id): ?User
    {
        return $this->entityManager->getRepository(User::class)->findOneBy(['id' => $id]);
    }

    public function createApiToken(User $user): string
    {
        $apiToken = sha1(uniqid('token'));
        $user->setApiToken($apiToken);
        $user->setApiTokenGeneratedAt();
        $this->flush();

        return $apiToken;
    }

    public function findUserByApiToken(string $apiToken): ?User
    {
        /** @var User|null $user */
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['apiToken' => $apiToken]);

        return $user;
    }

    public function update(User $user, UpdateUserModel $updateUserModel): void
    {
        if ($updateUserModel->email) {
            $user->setEmail($updateUserModel->email);
        }

        if ($updateUserModel->firstName) {
            $user->setFirstName($updateUserModel->firstName);
        }

        if ($updateUserModel->password) {
            $user->setPassword($this->userPasswordHasher->hashPassword($user, $updateUserModel->password));
        }

        $this->flush();
    }
}
