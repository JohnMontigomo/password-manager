<?php

namespace Api\AccountType;

use App\Tests\Api\AbstractWebTestCase;

# todo негативный сценарий с ошибкой авторизации

class GetCollectionAccountTypeTest extends AbstractWebTestCase
{
    public function testGetAccountTypeSuccess(): void
    {
        $count = rand(1, 9);
        $this->crateCollectionAccountType($count);

        $this->getCollectionAccountType();

        $this->assertEquals(200, $this->getResponseStatusCode());
        $this->assertTrue(count($this->getResponseContent()) === $count);
    }
}
