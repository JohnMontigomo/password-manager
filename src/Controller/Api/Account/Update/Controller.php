<?php

namespace App\Controller\Api\Account\Update;

use App\Controller\Exception\AccessDeniedException;
use App\Controller\SiteRouteEnum\UrlEnum;
use App\Domain\Entity\Account;
use App\Domain\Enum\MessageEnum;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class Controller
{
    private const CONTROLLER_URL = UrlEnum::AccountV1->value;

    public function __construct(private readonly Handler $handler)
    {
    }

    #[Route(path:self::CONTROLLER_URL . '/{id}', methods: ['PATCH'])]
    public function __invoke(
        #[MapEntity(id: 'id')] ?Account $account,
        #[MapRequestPayload] UpdateAccountDTO $updateAccountDTO,
        Request $request
    ): Response {
        if ($account instanceof Account) {
            $this->handler->update($account, $updateAccountDTO, $request);

            return new JsonResponse([MessageEnum::Result->value => true], Response::HTTP_OK);
        }

        return new JsonResponse([
            MessageEnum::Message->value => MessageEnum::AccountNotFound->value
        ], Response::HTTP_NOT_FOUND);
    }
}

