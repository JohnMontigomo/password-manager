<?php

namespace App\Domain\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Domain\Entity\Interface\EntityInterface;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gebler\EncryptedFieldsBundle\Attribute\EncryptedField;

#[ORM\Table(name: '`account')]
#[ORM\Entity]
#[ApiResource]
#[ORM\HasLifecycleCallbacks]
class Account implements EntityInterface
{
    #[ORM\Column(name: 'id', type: 'bigint', unique: true)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private ?int $id = null;

    #[EncryptedField]
    #[ORM\Column(name: 'title', type: 'string', nullable: false)]
    private string $title;

    #[EncryptedField]
    #[ORM\Column(name: 'login', type: 'string', nullable: false)]
    private string $login;

    #[EncryptedField]
    #[ORM\Column(name: 'password', type: 'string', nullable: false)]
    private string $password;

    #[ORM\ManyToOne(targetEntity: AccountType::class, inversedBy: 'account')]
    private ?AccountType $accountType;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: '`user`')]
    private User $user;

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
