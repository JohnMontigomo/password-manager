<?php

namespace App\Controller\Api\AccountType\Delete\v1;

use App\Controller\Exception\AccessDeniedException;
use App\Controller\Exception\AccountTypeHasAccountException;
use App\Controller\SiteRouteEnum\UrlEnum;
use App\Domain\Entity\AccountType;
use App\Domain\Enum\MessageEnum;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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

    #[Route(path: self::CONTROLLER_URL . '/{id}', methods: ['DELETE'])]
    public function __invoke(#[MapEntity(id: 'id')] ?AccountType $accountType, Request $request): Response
    {
        $result = $this->handler->delete($accountType, $request);

        return new JsonResponse([MessageEnum::Result->value => $result], $result ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }
}
