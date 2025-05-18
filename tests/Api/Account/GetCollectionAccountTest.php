<?php

namespace Api\Account;

use App\Tests\Api\AbstractWebTestCase;

# todo негативный сценарий с ошибкой авторизации

class GetCollectionAccountTest extends AbstractWebTestCase
{
    public function testGetAccountSuccess(): void
    {
        $count = rand(1, 9);
        $this->crateCollectionAccount($count);

        $this->getCollectionAccount();

        $this->assertEquals(200, $this->getResponseStatusCode());
        $this->assertTrue(count($this->getResponseContent()) === $count);
    }
}
