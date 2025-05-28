<?php

namespace App\Controller\Api\Account\Get\v1;

use App\Application\Security\AuthService;
use App\Controller\Exception\AccessDeniedException;
use App\Domain\Entity\Account;
use App\Domain\Enum\MessageEnum;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class Handler
{
    public function __construct(
        private readonly AuthService $authService,
        private readonly SerializerInterface $serializer,
    ) {
    }

    /**
     * @throws AccessDeniedException
     */
    public function get(?Account $account, Request $request): JsonResponse
    {
        if ($account instanceof Account) {
            $this->authService->checkAccessByToken($account, $request);

            $userRole = $this->authService->getUserByToken($request)->getRoles();

            $json = $this->serializer->serialize(
                $account,
                'json',
                ['groups' => $userRole]
            );

            return new JsonResponse($json, Response::HTTP_OK, [], true);
        }

        return new JsonResponse([
            MessageEnum::Message->value => MessageEnum::AccountNotFound->value
        ], Response::HTTP_NOT_FOUND);
    }
}
