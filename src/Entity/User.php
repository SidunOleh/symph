<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(
    name: 'login_pass_unique',
    columns: ['login', 'pass',]
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 8)]
    private ?string $login = null;

    #[ORM\Column(type: Types::STRING, length: 8)]
    private ?string $phone = null;

    #[ORM\Column(type: Types::STRING, length: 8)]
    private ?string $pass = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    public function getPass(): ?string
    {
        return $this->pass;
    }

    public function setPass(string $pass): void
    {
        $this->pass = $pass;
    }

    public function getRoles(): array
    {
        return [];
    }
    
    public function eraseCredentials(): void 
    {

    }

    public function getUserIdentifier(): string
    {
        return $this->id;
    }

    public function getPassword(): ?string
    {
        return $this->pass;
    }
}
