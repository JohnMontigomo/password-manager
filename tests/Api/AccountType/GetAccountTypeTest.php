<?php

namespace Api\AccountType;

use App\Tests\Api\AbstractWebTestCase;

# todo негативный сценарий с ошибкой авторизации
# todo негативный сценарий с неправильным id

class GetAccountTypeTest extends AbstractWebTestCase
{
    public function testGetAccountTypeSuccess(): void
    {
        $id = $this->createAccountType();

        $this->getAccountType($id);

        $this->assertEquals(200, $this->getResponseStatusCode());
        $this->assertTrue((int)$this->getResponseContent()['id'] > 0);
    }
}
