<?php

namespace App\Controller\Api\AccountType\Create\v1;

use App\Controller\SiteRouteEnum\UrlEnum;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class Controller
{
    private const CONTROLLER_URL = UrlEnum::AccountTypeV1->value;

    public function __construct(
        private readonly Handler $handler,
    ) {
    }

    #[Route(path: self::CONTROLLER_URL, methods: ['POST'])]
    public function __invoke(
        #[MapRequestPayload] InputAccountTypeDTO $inputAccountTypeDTO,
        Request $request
    ): OutputAccountTypeDTO {
        return $this->handler->create($inputAccountTypeDTO, $request);
    }
}
