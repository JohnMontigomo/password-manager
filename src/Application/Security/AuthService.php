<?php

namespace App\Application\Security;

use App\Controller\Exception\AccessDeniedException;
use App\Controller\Exception\UnauthorizedException;
use App\Domain\Entity\Account;
use App\Domain\Entity\AccountType;
use App\Domain\Entity\User;
use App\Domain\Service\UserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AuthService
{
    public function __construct(
        private readonly UserService $userService,
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function isCredentialsValid(string $email, string $password): bool
    {
        $user = $this->userService->findUserByEmail($email);
        if ($user === null) {
            return false;
        }

        return $this->passwordHasher->isPasswordValid($user, $password);
    }

    public function createApiToken(string $email): ?string
    {
        return $this->userService->createApiToken($email);
    }

    /**
     * @param Request $request
     * @param Account|AccountType $resource
     * @return void
     * @throws AccessDeniedException
     */
    public function checkAccessByToken(Account|AccountType $resource, Request $request): void
    {
        $authorization = $request->headers->get('Authorization');
        $token = str_starts_with($authorization, 'Bearer ') ? substr($authorization, 7) : null;
        $user = $this->userService->findUserByApiToken($token);

        if ($user !== $resource->getUser()) {
            throw new AccessDeniedException();
        }
    }

    /**
     * @param Request $request
     * @return void
     * @throws AccessDeniedException
     * @throws UnauthorizedException
     */
    public function checkAccessByPassword(Request $request): void
    {
        $user = $request->getUser();
        $password = $request->getPassword();
        if (!$user || !$password) {
            throw new UnauthorizedException();
        }
        if (!$this->isCredentialsValid($user, $password)) {
            throw new AccessDeniedException();
        }
    }

    public function getUserByToken(Request $request): User
    {
        $authorization = $request->headers->get('Authorization');
        $token = str_starts_with($authorization, 'Bearer ') ? substr($authorization, 7) : null;

        return $this->userService->findUserByApiToken($token);
    }
}
