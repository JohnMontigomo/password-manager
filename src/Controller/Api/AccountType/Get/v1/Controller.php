<?php

namespace App\Controller\Api\AccountType\Get\v1;

use App\Controller\SiteRouteEnum\UrlEnum;
use App\Domain\Entity\AccountType;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class Controller
{
    private const CONTROLLER_URL = UrlEnum::AccountTypeV1->value;

    public function __construct(
        private readonly Handler $handler,
    ) {
    }

    #[Route(path: self::CONTROLLER_URL . '/{id}', methods: ['GET'])]
    public function __invoke(#[MapEntity(id: 'id')] ?AccountType $accountType, Request $request): JsonResponse
    {
        return $this->handler->get($accountType, $request);
    }
}

