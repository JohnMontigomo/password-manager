<?php

namespace App\Controller\Api\Account\GetCollection\v1;

use App\Application\Security\AuthService;
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

    public function getCollection(Request $request): JsonResponse
    {
        $user = $this->authService->getUserByToken($request);
        $userRole = $this->authService->getUserByToken($request)->getRoles();

        $accountArray = $user->getAccounts()->toArray();
        $response  = [];

        foreach ($accountArray as $account) {
            $account = $this->serializer->serialize(
                $account,
                'json',
                ['groups' => $userRole]
            );

            $response[] = json_decode($account, true);
        }

        return new JsonResponse(json_encode($response), Response::HTTP_OK, [], true);
    }
}
