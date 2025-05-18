<?php

namespace Api\User;

use App\Domain\Enum\MessageEnum;
use App\Tests\Api\AbstractWebTestCase;

class UpdateUserTest extends AbstractWebTestCase
{
    public function testUpdateUserSuccess(): void
    {
        $this->updateUser();

        $this->assertEquals(200, $this->getResponseStatusCode());
        $this->assertTrue($this->getResponseContent()[MessageEnum::Result->value]);
        $this->assertTrue($this->checkUserRepository());
    }

    public function testUpdateUserErrorEmail(): void
    {
        $this->updateUser(true);

        $this->assertEquals(400, $this->getResponseStatusCode());
        $this->assertTrue(str_contains($this->getResponseContent()['email'], $this->getInputUserDTO()->email));
    }

    public function testUpdateUserErrorAuth(): void
    {
        $this->updateUser(false, true);

        $this->assertEquals(403, $this->getResponseStatusCode());
        $this->assertTrue($this->getResponseContent()[MessageEnum::Message->value] === MessageEnum::AccessDenied->value);
    }
}
