<?php

namespace App\Controller\Api\Account\Get\v1;

use App\Application\Security\AuthService;
use App\Controller\Exception\AccessDeniedException;
use App\Domain\Entity\Account;
use App\Domain\Enum\MessageEnum;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Handler
{
    public function __construct(
        private readonly AuthService $authService,
    ) {
    }

    /**
     * @param Account|null $account
     * @param Request $request
     * @return OutputAccountDTO|JsonResponse
     * @throws AccessDeniedException
     */
    public function get(?Account $account, Request $request): OutputAccountDTO|JsonResponse
    {
        if ($account instanceof Account) {
            $this->authService->checkAccessByToken($account, $request);

            return new OutputAccountDTO(
                $account->getId(),
                $account->getTitle(),
                $account->getAccountType()->getId() ?? null,
                $account->getAccountType()->getTitle() ?? null,
            );
        }

        return new JsonResponse([
            MessageEnum::Message->value => MessageEnum::AccountNotFound->value
        ], Response::HTTP_NOT_FOUND);
    }
}
