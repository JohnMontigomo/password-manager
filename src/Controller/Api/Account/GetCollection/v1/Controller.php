<?php

namespace App\Controller\Api\Account\GetCollection\v1;

use App\Controller\SiteRouteEnum\UrlEnum;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class Controller
{
    private const CONTROLLER_URL = UrlEnum::AccountCollectionV1->value;

    public function __construct(
        private readonly Handler $handler,
    ) {
    }

    #[Route(path: self::CONTROLLER_URL, methods: ['GET'])]
    public function __invoke(Request $request): JsonResponse
    {
        return $this->handler->getCollection($request);
    }
}
