<?php

namespace App\Controller\SiteRouteEnum;

enum UrlEnum: string
{
    case PublicUserV1  = '/api/public/user/v1';
    case UserV1        = '/api/user/v1';
    case TokenV1       = '/api/api-token/v1';

    case AccountV1     = '/api/account/v1';
    case AccountTypeV1 = '/api/account-type/v1';
}
