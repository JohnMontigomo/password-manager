<?php

namespace App\Domain\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Domain\Entity\Interface\EntityInterface;
use App\Domain\Enum\UserRoleEnum;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Table(name: '`account_type')]
#[ORM\Entity]
#[ApiResource]
#[ORM\HasLifecycleCallbacks]
class AccountType implements EntityInterface
{
    private const ROLE_ADMIN = UserRoleEnum::ROLE_ADMIN->value;
    private const ROLE_USER = UserRoleEnum::ROLE_USER->value;
    
    #[ORM\Column(name: 'id', type: 'bigint', unique: true)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[Groups([self::ROLE_ADMIN, self::ROLE_USER])]
    private ?int $id = null;

    #[ORM\Column(name: 'title', type: 'string', nullable: false)]
    #[Groups([self::ROLE_ADMIN, self::ROLE_USER])]
    private string $title;

    #[ORM\OneToMany(targetEntity: Account::class, mappedBy: 'account_type')]
    private ?Collection $accounts;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: '`user`')]
    private User $user;

    #[ORM\Column(name: 'created_at', type: 'datetime', nullable: false)]
    #[Groups([self::ROLE_ADMIN])]
    private DateTime $createdAt;

    #[ORM\Column(name: 'updated_at', type: 'datetime', nullable: false)]
    #[Groups([self::ROLE_ADMIN])]
    private DateTime $updatedAt;

    public function __construct()
    {
        $this->accounts = new ArrayCollection();
    }

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

    public function getAccounts(): ?Collection
    {
        return $this->accounts;
    }

    public function setAccounts(?Collection $accounts): void
    {
        $this->accounts = $accounts;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
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
