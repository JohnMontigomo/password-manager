<?php

namespace App\Controller\Exception;

use App\Domain\Enum\MessageEnum;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class AccessDeniedException extends Exception implements HttpCompliantExceptionInterface
{
    public function getHttpCode(): int
    {
        return Response::HTTP_FORBIDDEN;
    }

    public function getHttpResponseBody(): string
    {
        return MessageEnum::AccessDenied->value;
    }
}
