<?php

namespace App\Controller\Api\AccountType\GetCollection\v1;

use App\Application\Security\AuthService;
use App\Controller\Api\AccountType\Get\v1\OutputAccountTypeDTO;
use App\Domain\Service\AccountService;
use Symfony\Component\HttpFoundation\Request;

class Handler
{
    public function __construct(
        private readonly AuthService    $authService,
        private readonly AccountService $accountService,
    ) {
    }

    /**
     * @param Request $request
     * @return OutputAccountTypeDTO[]
     */
    public function getCollection(Request $request): array
    {
        $user = $this->authService->getUserByToken($request);
        $accountTypeArray =  $user->getAccountTypes()->toArray();
        $outputDTOArray = [];

        foreach ($accountTypeArray as $accountType) {
            $outputDTOArray[] = new OutputAccountTypeDTO(
                $accountType->getId(),
                $accountType->getTitle(),
                $this->accountService->getAccountIdByAccountTypeId($accountType->getId()),
            );
        }

        return  $outputDTOArray;
    }
}
