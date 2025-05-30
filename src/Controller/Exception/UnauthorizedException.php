<?php

namespace App\Controller\Exception;

use App\Domain\Enum\MessageEnum;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class UnauthorizedException extends Exception implements HttpCompliantExceptionInterface
{
    public function getHttpCode(): int
    {
        return Response::HTTP_UNAUTHORIZED;
    }

    public function getHttpResponseBody(): string
    {
        return MessageEnum::Unauthorized->value;
    }
}
