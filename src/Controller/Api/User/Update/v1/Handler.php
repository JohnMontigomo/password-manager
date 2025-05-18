<?php

namespace App\Controller\Api\User\Update\v1;

use App\Application\Security\AuthService;
use App\Controller\Exception\AccessDeniedException;
use App\Controller\Exception\UnauthorizedException;
use App\Domain\Enum\MessageEnum;
use App\Domain\Factory\ModelFactory;
use App\Domain\Model\User\UpdateUserModel;
use App\Domain\Service\UserService;
use Symfony\Component\HttpFoundation\Request;

class Handler
{
    public function __construct(
        private readonly AuthService  $authService,
        private readonly ModelFactory $modelFactory,
        private readonly UserService  $userService,
    ) {
    }

    /**
     * @throws AccessDeniedException
     * @throws UnauthorizedException
     */
    public function update(UpdateUserDTO $updateUserDTO, Request $request): string
    {
        $this->authService->checkAccessByPassword($request);

        $user = $this->userService->findUserByEmail($request->getUser());

        $updateUserModel = $this->modelFactory->makeModel(
            UpdateUserModel::class,
            $updateUserDTO->email ?? null,
            $updateUserDTO->firstName ?? null,
            $updateUserDTO->password ?? null,
        );

        $this->userService->update($user, $updateUserModel);

        return MessageEnum::Ok->value;
    }
}
