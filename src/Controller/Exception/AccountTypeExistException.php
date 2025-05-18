<?php

namespace App\Controller\Exception;

use App\Domain\Enum\MessageEnum;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class AccountTypeExistException extends Exception implements HttpCompliantExceptionInterface
{
    public function getHttpCode(): int
    {
        return Response::HTTP_OK;
    }

    public function getHttpResponseBody(): string
    {
        return MessageEnum::AccountTypeExists->value;
    }
}
