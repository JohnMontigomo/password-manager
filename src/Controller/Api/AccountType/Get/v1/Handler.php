<?php

namespace App\Controller\Api\AccountType\Get\v1;

use App\Application\Security\AuthService;
use App\Controller\Exception\AccessDeniedException;
use App\Domain\Entity\AccountType;
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
    public function get(?AccountType $accountType, Request $request): JsonResponse
    {
        if ($accountType instanceof AccountType) {
            $this->authService->checkAccessByToken($accountType, $request);

            $userRole = $this->authService->getUserByToken($request)->getRoles();

            $json = $this->serializer->serialize(
                $accountType,
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
