<?php

namespace App\Controller\Api\Account\Create\v1;

use App\Application\Security\AuthService;
use App\Controller\Exception\AccountExistException;
use App\Domain\Entity\User;
use App\Domain\Factory\ModelFactory;
use App\Domain\Model\Account\CreateAccountModel;
use App\Domain\Service\AccountService;
use App\Domain\Service\AccountTypeService;
use PassGeneratorBundle\Service\PassGenerator;
use Symfony\Component\HttpFoundation\Request;

class Handler
{
    public function __construct(
        private readonly PassGenerator      $passGenerator,
        private readonly ModelFactory       $modelFactory,
        private readonly AuthService        $authService,
        private readonly AccountService     $accountService,
        private readonly AccountTypeService $accountTypeService
    ) {
    }

    /**
     * @throws AccountExistException
     */
    public function create(InputAccountDTO $inputAccountDTO, Request $request): OutputAccountDTO
    {
        $user = $this->authService->getUserByToken($request);

        $this->checkAccountUniqueForUser($user, $inputAccountDTO->title);

        $accountModel = $this->modelFactory->makeModel(
            CreateAccountModel::class,
            $inputAccountDTO->title,
            $inputAccountDTO->login,
            $inputAccountDTO->password ?? $this->passGenerator->generatePassword(),
            $this->accountTypeService->getAccountTypeById((int)$inputAccountDTO->accountTypeId),
            $user,
        );

        return new OutputAccountDTO(
            $this->accountService->create($accountModel),
        );
    }

    /**
     * @param User $user
     * @param string $title
     * @return void
     * @throws AccountExistException
     */
    private function checkAccountUniqueForUser(User $user, string $title): void
    {
        $accountArray = $user->getAccounts()->toArray();

        foreach ($accountArray as $account) {
            if ($account->getTitle() === $title) {
                throw new AccountExistException();
            }
        }
    }
}
