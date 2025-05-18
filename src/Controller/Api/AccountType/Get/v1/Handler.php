<?php

namespace App\Controller\Api\AccountType\Get\v1;

use App\Application\Security\AuthService;
use App\Controller\Exception\AccessDeniedException;
use App\Domain\Entity\AccountType;
use App\Domain\Enum\MessageEnum;
use App\Domain\Service\AccountService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Handler
{
    public function __construct(
        private readonly AccountService $accountService,
        private readonly AuthService    $authService,
    ) {
    }

    /**
     * @param AccountType|null $accountType
     * @param Request $request
     * @return OutputAccountTypeDTO|JsonResponse
     * @throws AccessDeniedException
     */
    public function get(?AccountType $accountType, Request $request): OutputAccountTypeDTO|JsonResponse
    {
        if ($accountType instanceof AccountType) {
            $this->authService->checkAccessByToken($accountType, $request);

            return new OutputAccountTypeDTO(
                $accountType->getId(),
                $accountType->getTitle(),
                $this->accountService->getAccountIdByAccountTypeId($accountType->getId()),
            );

        }

        return new JsonResponse([
            MessageEnum::Message->value => MessageEnum::AccountNotFound->value
        ], Response::HTTP_NOT_FOUND);
    }
}
