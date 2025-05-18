<?php

namespace App\Controller\Api\Token\Create\v1;

use App\Application\Security\AuthService;
use App\Controller\Exception\AccessDeniedException;
use App\Controller\Exception\UnauthorizedException;
use Symfony\Component\HttpFoundation\Request;

class Handler
{
    public function __construct(
        private readonly AuthService $authService,
    ) {
    }

    /**
     * @throws AccessDeniedException
     * @throws UnauthorizedException
     */
    public function createApiToken(Request $request): string
    {
        $this->authService->checkAccessByPassword($request);

        return $this->authService->createApiToken($request->getUser());
    }
}
