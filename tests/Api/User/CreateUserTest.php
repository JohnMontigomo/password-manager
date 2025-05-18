<?php

namespace App\Tests\Api\User;

use App\Tests\Api\AbstractWebTestCase;

class CreateUserTest extends AbstractWebTestCase
{
    public function testCreateUserSuccess(): void
    {
        $this->assertEquals(200, $this->getResponseStatusCode());
        $this->assertTrue($this->userId > 0);
        $this->assertTrue($this->checkUserRepository());
    }

    public function testCreateUserError(): void
    {
        $this->createUserError();

        $this->assertEquals(400, $this->getResponseStatusCode());
        $this->assertTrue(str_contains($this->getResponseContent()['email'], $this->getInputUserDTO()->email));
    }
}
