<?php

namespace App\Controller\Api\User\Create\v1;

use App\Controller\SiteRouteEnum\UrlEnum;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class Controller
{
    private const CONTROLLER_URL = UrlEnum::PublicUserV1->value;

    public function __construct(
        private readonly Handler $handler,
    ) {
    }

    #[Route(path: self::CONTROLLER_URL, methods: ['POST'])]
    public function __invoke(#[MapRequestPayload] InputUserDTO $inputUserDTO): OutputUserDTO
    {
        return $this->handler->create($inputUserDTO);
    }
}
