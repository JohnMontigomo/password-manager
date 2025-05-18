<?php

namespace Api\AccountType;

use App\Tests\Api\AbstractWebTestCase;

# todo негативный сценарий с ошибкой авторизации
# todo негативный сценарий с повторением названия

class CreateAccountTypeTest extends AbstractWebTestCase
{
    public function testCreateAccountTypeSuccess(): void
    {
        $id = $this->createAccountType();

        $this->assertEquals(200, $this->getResponseStatusCode());
        $this->assertTrue($id > 0);
        $this->assertTrue($this->checkAccountTypeRepository($id));
    }
}
