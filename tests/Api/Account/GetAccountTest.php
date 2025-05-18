<?php

namespace Api\Account;

use App\Tests\Api\AbstractWebTestCase;

# todo негативный сценарий с ошибкой авторизации
# todo негативный сценарий с неправильным id

class GetAccountTest extends AbstractWebTestCase
{
    public function testCreateAccountSuccess(): void
    {
        $id = $this->createAccount();

        $this->getAccount($id);

        $this->assertEquals(200, $this->getResponseStatusCode());
        $this->assertTrue( $id > 0);
    }
}
