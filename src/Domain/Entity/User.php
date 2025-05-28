<?php

namespace App\Domain\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Domain\Entity\Interface\EntityInterface;
use App\Domain\Enum\UserRoleEnum;
use DateTime;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Table(name: '`user`')]
#[ORM\Entity]
#[ApiResource]
#[ORM\HasLifecycleCallbacks]
class User implements EntityInterface, UserInterface, PasswordAuthenticatedUserInterface
{
    private const ROLE_ADMIN = UserRoleEnum::ROLE_ADMIN->value;

    #[ORM\Column(name: 'id', type: 'bigint', unique: true)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[Groups([self::ROLE_ADMIN])]
    private ?int $id = null;

    #[ORM\Column(name: 'email', type: 'string', unique: true, nullable: false)]
    private string $email;

    #[ORM\Column(name: 'first_name', type: 'string', nullable: false)]
    private string $firstName;

    #[ORM\Column(name: 'roles', type: 'json', length: 1024, nullable: false)]
    private ?array $roles = [];

    #[ORM\Column(name: 'password', type: 'string', nullable: false)]
    private string $password;

    #[ORM\Column(name: 'api_token', type: 'string', unique: true, nullable: true)]
    private ?string $apiToken = null;

    #[ORM\Column(name: 'api_token_generated_at', type: 'datetime', nullable: true)]
    private ?DateTime $apiTokenGeneratedAt;

    #[ORM\Column(name: 'is_active', type: 'boolean', nullable: false)]
    private bool $isActive;

    #[ORM\OneToMany(targetEntity: Account::class, mappedBy: 'user')]
    private ?Collection $accounts;

    #[ORM\OneToMany(targetEntity: AccountType::class, mappedBy: 'user')]
    private ?Collection $accountTypes;

    #[ORM\Column(name: 'created_at', type: 'datetime', nullable: false)]
    private DateTime $createdAt;

    #[ORM\Column(name: 'updated_at', type: 'datetime', nullable: false)]
    private DateTime $updatedAt;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getApiToken(): ?string
    {
        return $this->apiToken;
    }

    public function setApiToken(?string $apiToken): void
    {
        $this->apiToken = $apiToken;
    }

    public function getApiTokenGeneratedAt(): ?DateTime
    {
        return $this->apiTokenGeneratedAt;
    }

    public function setApiTokenGeneratedAt(): void
    {
        $this->apiTokenGeneratedAt = new DateTime();
    }

    /**
     * @return string[]
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = UserRoleEnum::ROLE_USER->value;

        return array_unique($roles);
    }

    public function setRoles(string $role): void
    {
        $this->roles[] = $role;
    }

    public function eraseCredentials(): void
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function getIsActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(int $isActive): void
    {
        $this->isActive = $isActive;
    }

    public function getAccounts(): ?Collection
    {
        return $this->accounts;
    }

    public function setAccounts(?Collection $accounts): void
    {
        $this->accounts = $accounts;
    }

    public function getAccountTypes(): ?Collection
    {
        return $this->accountTypes;
    }

    public function setAccountTypes(?Collection $accountTypes): void
    {
        $this->accountTypes = $accountTypes;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    #[ORM\PrePersist]
    public function setCreatedAt(): void
    {
        $this->createdAt = new DateTime();
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function setUpdatedAt(): void
    {
        $this->updatedAt = new DateTime();
    }
}
