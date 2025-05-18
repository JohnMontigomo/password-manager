<?php

namespace Api\Account;

use App\Tests\Api\AbstractWebTestCase;

# todo негативный сценарий с ошибкой авторизации
# todo негативный сценарий с неправильным id

class UpdateAccountTest extends AbstractWebTestCase
{
    public function testUpdateAccountSuccess(): void
    {
        $id = $this->createAccount();

        $this->updateAccount($id);

        $this->assertEquals(200, $this->getResponseStatusCode());
        $this->assertTrue( $id > 0);
        $this->assertTrue($this->checkAccountRepository($id));
    }
}
