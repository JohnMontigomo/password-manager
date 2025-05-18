<?php

namespace Api\Account;

use App\Domain\Enum\MessageEnum;
use App\Tests\Api\AbstractWebTestCase;

# todo негативный сценарий с ошибкой авторизации
# todo негативный сценарий с неправильным id

class DeleteAccountTest extends AbstractWebTestCase
{
    public function testDeleteAccountSuccess(): void
    {
        $id = $this->createAccount();

        $this->deleteAccount($id);

        $this->assertEquals(200, $this->getResponseStatusCode());
        $this->assertTrue($this->getResponseContent()[MessageEnum::Result->value]);
        $this->assertTrue(!$this->checkAccountRepository($id));
    }
}
