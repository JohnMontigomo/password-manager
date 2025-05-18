<?php

namespace App\Controller\Api\Token\Create\v1;

use App\Controller\SiteRouteEnum\UrlEnum;
use App\Domain\Enum\MessageEnum;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class Controller
{
    private const CONTROLLER_URL = UrlEnum::TokenV1->value;

    public function __construct(private readonly Handler $handler)
    {
    }

    #[Route(path: self::CONTROLLER_URL, methods: ['POST'])]
    public function __invoke(Request $request): Response
    {
        return new JsonResponse([MessageEnum::ApiToken->value => $this->handler->createApiToken($request)]);
    }
}
