<?php

namespace Api\AccountType;

use App\Domain\Enum\MessageEnum;
use App\Tests\Api\AbstractWebTestCase;

# todo негативный сценарий с ошибкой авторизации
# todo негативный сценарий с неправильным id

class DeleteAccountTypeTest extends AbstractWebTestCase
{
    public function testDeleteAccountTypeSuccess(): void
    {
        $id = $this->createAccountType();

        $this->deleteAccountType($id);

        $this->assertEquals(200, $this->getResponseStatusCode());
        $this->assertTrue($this->getResponseContent()[MessageEnum::Result->value]);
        $this->assertTrue(!$this->checkAccountTypeRepository($id));
    }
}
