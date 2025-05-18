<?php

namespace App\Controller\Api\Account\GetCollection\v1;

use App\Application\Security\AuthService;
use Symfony\Component\HttpFoundation\Request;

class Handler
{
    public function __construct(
        private readonly AuthService $authService,
    ) {
    }

    /**
     * @param Request $request
     * @return OutputAccountDTO[]
     */
    public function getCollection(Request $request): array
    {
        $user = $this->authService->getUserByToken($request);
        $accountArray = $user->getAccounts()->toArray();
        $outputDTOArray = [];

        foreach ($accountArray as $account) {
            $outputDTOArray[] = new OutputAccountDTO(
                $account->getId(),
                $account->getTitle(),
                $account->getAccountType()->getId() ?? null,
                $account->getAccountType()->getTitle() ?? null,
            );
        }

        return  $outputDTOArray;
    }
}
