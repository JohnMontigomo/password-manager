<?php

namespace App\Controller\Exception;

use App\Domain\Enum\MessageEnum;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class AccountExistException extends Exception implements HttpCompliantExceptionInterface
{
    public function getHttpCode(): int
    {
        return Response::HTTP_OK;
    }

    public function getHttpResponseBody(): string
    {
        return MessageEnum:: AccountExists->value;
    }
}
