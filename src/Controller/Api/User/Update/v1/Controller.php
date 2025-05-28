<?php

namespace App\Controller\Api\User\Update\v1;

use App\Controller\Exception\AccessDeniedException;
use App\Controller\Exception\UnauthorizedException;
use App\Controller\SiteRouteEnum\UrlEnum;
use App\Domain\Enum\MessageEnum;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class Controller
{
    private const CONTROLLER_URL = UrlEnum::UserUpdateV1->value;

    public function __construct(private readonly Handler $handler)
    {
    }

    #[Route(path:self::CONTROLLER_URL, methods: ['PATCH'])]
    public function __invoke(#[MapRequestPayload] UpdateUserDTO $updateUserDTO, Request $request): Response
    {
        $this->handler->update($updateUserDTO, $request);

        return new JsonResponse([MessageEnum::Result->value => true], Response::HTTP_OK);
    }
}
