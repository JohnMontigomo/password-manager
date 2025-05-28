<?php

namespace App\Controller\Api\AccountType\Create\v1;

use App\Application\Security\AuthService;
use App\Controller\Exception\AccountTypeExistException;
use App\Domain\Entity\User;
use App\Domain\Factory\ModelFactory;
use App\Domain\Model\AccountType\CreateAccountTypeModel;
use App\Domain\Service\AccountTypeService;
use Symfony\Component\HttpFoundation\Request;

class Handler
{
    public function __construct(
        private readonly AuthService        $authService,
        private readonly ModelFactory       $modelFactory,
        private readonly AccountTypeService $accountTypeService
    ) {
    }

    /**
     * @throws AccountTypeExistException
     */
    public function create(InputAccountTypeDTO $inputAccountTypeDTO, Request $request): OutputAccountTypeDTO
    {
        $user = $this->authService->getUserByToken($request);

        $this->checkAccountTypeUniqueForUser($user, $inputAccountTypeDTO->title);

        $accountTypeModel = $this->modelFactory->makeModel(
            CreateAccountTypeModel::class,
            $inputAccountTypeDTO->title,
            $user,
        );

        return new OutputAccountTypeDTO(
            $this->accountTypeService->create($accountTypeModel),
        );
    }

    /**
     * @throws AccountTypeExistException
     */
    private function checkAccountTypeUniqueForUser(User $user, string $title): void
    {
        $accountTypesArray = $user->getAccountTypes()->toArray();

        foreach ($accountTypesArray as $accountType) {
            if ($accountType->getTitle() === $title) {
                throw new AccountTypeExistException();
            }
        }
    }
}
