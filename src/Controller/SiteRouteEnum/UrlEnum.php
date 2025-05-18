<?php

namespace App\Controller\SiteRouteEnum;

enum UrlEnum: string
{
    case PublicUserV1            = '/api/public/user/v1';

    case UserUpdateV1            = '/api/user-update/v1';

    case TokenV1                 = '/api/get-api-token/v1';

    case AccountV1               = '/api/account/v1';
    case AccountCollectionV1     = '/api/account-collection/v1';

    case AccountTypeV1           = '/api/account-type/v1';
    case AccountTypeCollectionV1 = '/api/account-type-collection/v1';
}
