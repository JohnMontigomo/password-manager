<?php

namespace App\Domain\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Domain\Entity\Interface\EntityInterface;
use App\Domain\Enum\UserRoleEnum;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gebler\EncryptedFieldsBundle\Attribute\EncryptedField;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Table(name: '`account')]
#[ORM\Entity]
#[ApiResource]
#[ORM\HasLifecycleCallbacks]
class Account implements EntityInterface
{
    private const ROLE_ADMIN = UserRoleEnum::ROLE_ADMIN->value;
    private const ROLE_USER = UserRoleEnum::ROLE_USER->value;
    
    #[ORM\Column(name: 'id', type: 'bigint', unique: true)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[Groups([self::ROLE_ADMIN, self::ROLE_USER])]
    private ?int $id = null;

    #[EncryptedField]
    #[ORM\Column(name: 'title', type: 'string', nullable: false)]
    #[Groups([self::ROLE_ADMIN, self::ROLE_USER])]
    private string $title;

    #[EncryptedField]
    #[ORM\Column(name: 'login', type: 'string', nullable: false)]
    #[Groups([self::ROLE_USER])]
    private string $login;

    #[EncryptedField]
    #[ORM\Column(name: 'password', type: 'string', nullable: false)]
    #[Groups([self::ROLE_USER])]
    private string $password;

    #[ORM\ManyToOne(targetEntity: AccountType::class, inversedBy: 'account')]
    #[Groups([self::ROLE_ADMIN, self::ROLE_USER])]
    private ?AccountType $accountType;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: '`user`')]
    #[Groups([self::ROLE_ADMIN])]
    private User $user;

    #[ORM\Column(name: 'created_at', type: 'datetime', nullable: false)]
    #[Groups([self::ROLE_ADMIN])]
    private DateTime $createdAt;

    #[ORM\Column(name: 'updated_at', type: 'datetime', nullable: false)]
    #[Groups([self::ROLE_ADMIN])]
    private DateTime $updatedAt;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getAccountType(): ?AccountType
    {
        return $this->accountType;
    }

    public function setAccountType(?AccountType $accountType): void
    {
        $this->accountType = $accountType;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
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

    #[Groups([self::ROLE_ADMIN])]
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
