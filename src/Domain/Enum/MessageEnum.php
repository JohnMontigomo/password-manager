<?php

namespace App\Domain\Enum;

enum MessageEnum: string
{
    case AccessDenied           =  'Access denied';
    case AccountExists          = 'The account title already exists for this user';
    case AccountTypeExists      = 'The AccountType already exists for this user';
    case AccountTypeHasAccounts = 'The account type has accounts of this user';
    case Unauthorized           = 'Unauthorized';

    case UserNotFound           = 'This user is not found';
    case AccountNotFound        = 'Account not found';

    case ApiToken               = 'api-token';
    case Result                 = 'success';
    case Message                = 'message';
    case Ok                     = 'ok';
}
