<?php

namespace Api\Account;

use App\Domain\Enum\MessageEnum;
use App\Tests\Api\AbstractWebTestCase;

# todo негативный сценарий с повторением названия аккаунта

class CreateAccountTest extends AbstractWebTestCase
{
    public function testCreateAccountSuccess(): void
    {
        $id = $this->createAccount();

        $this->assertEquals(200, $this->getResponseStatusCode());
        $this->assertTrue($id > 0);
        $this->assertTrue($this->checkAccountRepository($id));
    }

    public function testCreateAccountErrorAuth(): void
    {
        $this->createAccount(true);

        $this->assertEquals(403, $this->getResponseStatusCode());
        $this->assertTrue($this->getResponseContent()[MessageEnum::Message->value] === MessageEnum::AccessDenied->value);
    }
}
