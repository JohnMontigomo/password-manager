<?php

namespace App\Tests\Api;

use App\Controller\Api\Account\Create\v1\InputAccountDTO;
use App\Controller\Api\Account\Update\UpdateAccountDTO;
use App\Controller\Api\AccountType\Create\v1\InputAccountTypeDTO;
use App\Controller\Api\User\Create\v1\InputUserDTO;
use App\Controller\Api\User\Update\v1\UpdateUserDTO;
use App\Controller\SiteRouteEnum\UrlEnum;
use App\Domain\Entity\Account;
use App\Domain\Entity\AccountType;
use App\Domain\Entity\User;
use App\Domain\Enum\MessageEnum;
use App\Domain\Service\AccountService;
use App\Domain\Service\AccountTypeService;
use App\Domain\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AbstractWebTestCase extends WebTestCase
{
    protected $client;
    protected $userId;
    protected readonly UserService        $userService;
    protected readonly AccountService     $accountService;
    protected readonly AccountTypeService $accountTypeService;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->userId = $this->createUser();

        $this->userService = static::getContainer()->get(UserService::class);
        $this->accountService = static::getContainer()->get(AccountService::class);
        $this->accountTypeService = static::getContainer()->get(AccountTypeService::class);

        parent::setUp();
    }

    protected function getResponseStatusCode(): int
    {
        return $this->client->getResponse()->getStatusCode();
    }

    protected function getResponseContent(): array
    {
        return json_decode($this->client->getResponse()->getContent(), true);
    }

    protected function checkUserRepository(): bool
    {
        return $this->userService->getUserById($this->userId) instanceof User;
    }

    protected function checkAccountRepository(int $accountId): bool
    {
        return $this->accountService->getAccountById($accountId) instanceof Account;
    }

    protected function checkAccountTypeRepository(int $accountTypeId): bool
    {
        return $this->accountTypeService->getAccountTypeById($accountTypeId) instanceof AccountType;
    }

    protected function createUser(): int
    {
        $this->client->request(
            'POST',
            UrlEnum::PublicUserV1->value,
            [], [], ['CONTENT_TYPE' => 'application/json'],
            json_encode($this->getInputUserDTO()));

        return (int)$this->getResponseContent()['id'];
    }

    protected function createUserError(): void
    {
        $this->client->request(
            'POST',
            UrlEnum::PublicUserV1->value,
            [], [], ['CONTENT_TYPE' => 'application/json'],
            json_encode($this->getInputUserDTO()));
    }

    protected function updateUser(bool $errorEmail = false, bool $errorAuth = false): void
    {
        $this->client->request('PATCH', UrlEnum::UserUpdateV1->value,  [],  [], [
            'CONTENT_TYPE' => 'application/json',
            'PHP_AUTH_USER' => !$errorAuth ? $this->getInputUserDTO()->email : 'error',
            'PHP_AUTH_PW'   => !$errorAuth ? $this->getInputUserDTO()->password : 'error',
        ], json_encode(!$errorEmail ? $this->getUpdateUserDTO() : $this->getUpdateUserDTOError()));
    }

    protected function createApiToken(bool $errorAuth = false): ?string
    {
        $this->client->request('POST', UrlEnum::TokenV1->value,  [],  [], [
            'CONTENT_TYPE'  => 'application/json',
            'PHP_AUTH_USER' => !$errorAuth ? $this->getInputUserDTO()->email : 'error',
            'PHP_AUTH_PW'   => !$errorAuth ? $this->getInputUserDTO()->password : 'error',
        ]);

        return $errorAuth
            ? null
            : json_decode($this->client->getResponse()->getContent(), true)[MessageEnum::ApiToken->value];
    }

    protected function createAccountType(): int
    {
        $this->client->request('POST', UrlEnum::AccountTypeV1->value,  [],  [], [
            'CONTENT_TYPE' => 'application/json',
            'HTTP_AUTHORIZATION' => 'Bearer ' . $this->createApiToken()
        ], json_encode($this->getInputAccountTypeDTO()));

        return (int)$this->getResponseContent()['id'];
    }

    protected function crateCollectionAccountType(int $count): void
    {
        for ($i=0; $i<$count; $i++) {
            $this->createAccountType();
        }
    }

    protected function deleteAccountType(int $id): void
    {
        $this->client->request('DELETE', UrlEnum::AccountTypeV1->value . "/$id",  [],  [], [
            'CONTENT_TYPE' => 'application/json',
            'HTTP_AUTHORIZATION' => 'Bearer ' . $this->createApiToken()
        ]);
    }

    protected function getAccountType(int $id): void
    {
        $this->client->request('GET', UrlEnum::AccountTypeV1->value . "/$id",  [],  [], [
            'CONTENT_TYPE' => 'application/json',
            'HTTP_AUTHORIZATION' => 'Bearer ' . $this->createApiToken()
        ]);
    }

    protected function getCollectionAccountType(): void
    {
        $this->client->request('GET', UrlEnum::AccountTypeCollectionV1->value,  [],  [], [
            'CONTENT_TYPE' => 'application/json',
            'HTTP_AUTHORIZATION' => 'Bearer ' . $this->createApiToken()
        ]);
    }

    protected function createAccount(bool $errorAuth = false): ?int
    {
        $this->createAccountType();
        $accountTypeId = $this->getResponseContent()['id'];

        $this->client->request('POST', UrlEnum::AccountV1->value,  [],  [], [
            'CONTENT_TYPE' => 'application/json',
            'HTTP_AUTHORIZATION' => !$errorAuth ? 'Bearer ' . $this->createApiToken() : 'Bearer x',
        ], json_encode($this->getInputAccountDTO($accountTypeId)));

        return !$errorAuth ? $this->getResponseContent()['id'] : null;
    }

    protected function crateCollectionAccount(int $count): void
    {
        for ($i=0; $i<$count; $i++) {
            $this->createAccount();
        }
    }

    protected function deleteAccount(int $id): void
    {
        $this->client->request('DELETE', UrlEnum::AccountV1->value . "/$id",  [],  [], [
            'CONTENT_TYPE' => 'application/json',
            'HTTP_AUTHORIZATION' => 'Bearer ' . $this->createApiToken()
        ]);
    }

    protected function getAccount(int $id): void
    {
        $this->client->request('GET', UrlEnum::AccountV1->value . "/$id",  [],  [], [
            'CONTENT_TYPE' => 'application/json',
            'HTTP_AUTHORIZATION' => 'Bearer ' . $this->createApiToken()
        ]);
    }

    protected function getCollectionAccount(): void
    {
        $this->client->request('GET', UrlEnum::AccountCollectionV1->value,  [],  [], [
            'CONTENT_TYPE' => 'application/json',
            'HTTP_AUTHORIZATION' => 'Bearer ' . $this->createApiToken()
        ]);
    }

    protected function updateAccount($accountId): void
    {
        $accountTypeId = $this->createAccountType();

        $this->client->request('PATCH', UrlEnum::AccountV1->value . "/$accountId",  [],  [], [
            'CONTENT_TYPE' => 'application/json',
            'HTTP_AUTHORIZATION' => 'Bearer ' . $this->createApiToken()
        ], json_encode($this->getUpdateAccountDTO($accountTypeId)));
    }

    protected function getInputUserDTO(): InputUserDTO
    {
        return new InputUserDTO(
            "test@test.test",
            "test",
            "test-test",
            "ROLE_USER"
        );
    }

    private function getUpdateUserDTOError(): UpdateUserDTO
    {
        return new UpdateUserDTO(
            "test@test.test",
            "test-2",
            "test-test",
        );
    }

    private function getUpdateUserDTO(): UpdateUserDTO
    {
        return new UpdateUserDTO(
            "test@test.test-2",
            "test-2",
            "test-test",
        );
    }

    private function getInputAccountTypeDTO(): InputAccountTypeDTO
    {
       return new InputAccountTypeDTO(
            "testType-" . rand(1, 1000000000)
        );
    }

    private function getInputAccountDTO($accountTypeId): InputAccountDTO
    {
        return new InputAccountDTO(
            "title-" . rand(1, 1000000000),
            "login",
            "password",
            "$accountTypeId",
            "$this->userId"
        );
    }

    private function getUpdateAccountDTO($accountTypeId): UpdateAccountDTO
    {
        return new UpdateAccountDTO(
            "title-" . rand(1, 1000000000),
            "login",
            "password",
            $accountTypeId
        );
    }
}
