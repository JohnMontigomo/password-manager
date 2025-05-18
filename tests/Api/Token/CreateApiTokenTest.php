<?php

namespace Api\Token;

use App\Domain\Enum\MessageEnum;
use App\Tests\Api\AbstractWebTestCase;

class CreateApiTokenTest extends AbstractWebTestCase
{
    public function testCreateApiTokenSuccess(): void
    {
        $apiToken = $this->createApiToken();

        $this->assertEquals(200, $this->getResponseStatusCode());
        $this->assertTrue(strlen($apiToken) === 40);
    }

    public function testCreateApiTokenError(): void
    {
        $this->createApiToken(true);

        $this->assertEquals(403, $this->getResponseStatusCode());
        $this->assertTrue($this->getResponseContent()[MessageEnum::Message->value] === MessageEnum::AccessDenied->value);
    }
}
