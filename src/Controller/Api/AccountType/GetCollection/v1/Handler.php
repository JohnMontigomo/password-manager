<?php

namespace App\Controller\Api\AccountType\GetCollection\v1;

use App\Application\Security\AuthService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class Handler
{
    public function __construct(
        private readonly AuthService    $authService,
        private readonly SerializerInterface $serializer,
    ) {
    }

    public function getCollection(Request $request): JsonResponse
    {
        $user = $this->authService->getUserByToken($request);
        $userRole = $this->authService->getUserByToken($request)->getRoles();

        $accountTypeArray =  $user->getAccountTypes()->toArray();
        $response  = [];

        foreach ($accountTypeArray  as $accountType) {
            $accountType = $this->serializer->serialize(
                $accountType,
                'json',
                ['groups' => $userRole]
            );

            $response[] = json_decode($accountType, true);
        }

        return new JsonResponse(json_encode($response), Response::HTTP_OK, [], true);
    }
}
