<?php

namespace App\Controller\Api\User\Create\v1;

use App\Domain\Enum\UserRoleEnum;
use App\Domain\Factory\ModelFactory;
use App\Domain\Model\User\CreateUserModel;
use App\Domain\Service\UserService;

class Handler
{
    public function __construct(
        private readonly ModelFactory $modelFactory,
        private readonly UserService $userService,
    ) {
    }

    public function create(InputUserDTO $inputUserDTO): OutputUserDTO
    {
        $userModel = $this->modelFactory->makeModel(
            CreateUserModel::class,
            $inputUserDTO->email,
            $inputUserDTO->firstName,
            UserRoleEnum::tryFrom($inputUserDTO->role),
            $inputUserDTO->password,
            true,
        );

        return new OutputUserDTO(
            $this->userService->create($userModel),
        );
    }
}
