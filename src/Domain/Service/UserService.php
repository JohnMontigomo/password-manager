<?php

namespace App\Domain\Service;

use App\Domain\Entity\User;
use App\Domain\Enum\DigitalEnum;
use App\Domain\Enum\MessageEnum;
use App\Domain\Model\User\CreateUserModel;
use App\Domain\Model\User\UpdateUserModel;
use App\Domain\Repository\UserRepositoryInterface;
use DateInterval;
use DateTime;
use DateTimeZone;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly UserPasswordHasherInterface $userPasswordHasher,
    ) {
    }

    public function create(CreateUserModel $userModel): int
    {
        $user = new User();
        $user->setEmail($userModel->email);
        $user->setFirstName($userModel->firstName);
        $user->setPassword($this->userPasswordHasher->hashPassword($user, $userModel->password));
        $user->setRoles($userModel->role->value);
        $user->setIsActive($userModel->isActive);

        return $this->userRepository->create($user);
    }

    public function findUserByEmail(string $email): ?User
    {
        return $this->userRepository->findUserByEmail($email);
    }

    public function getUserById(int $id): ?User
    {
        return $this->userRepository->getUserById($id);
    }

    public function createApiToken(string $email): string
    {
        $user = $this->findUserByEmail($email);
        if ($user === null) {
            return MessageEnum::UserNotFound->value;
        }

        return $this->userRepository->createApiToken($user);
    }

    public function findUserByApiToken(string $apiToken): ?User
    {
        $user = $this->userRepository->findUserByApiToken($apiToken);

        if (!$user) {
            return null;
        }

        $apiTokenLifeTime = (string)DigitalEnum::ApiTokenLifeTime->value;

        if (
            $user->getApiTokenGeneratedAt()
                 ->add(DateInterval::createFromDateString( $apiTokenLifeTime . ' day'))
            < new DateTime()
        ) {
            return null;
        }

        return $user;
    }

    public function update(User $user, UpdateUserModel $updateUserModel): void
    {
        $this->userRepository->update($user, $updateUserModel);
    }
}
