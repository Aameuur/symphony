<?php


namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
#[UniqueEntity(fields: ['cin'], message: 'There is already an account with this CIN')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    public const ROLE_ADMIN = 'ROLE_ADMIN';
    public const ROLE_USER = 'ROLE_USER';
    public const ROLE_AGENT = 'ROLE_AGENT';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message: 'Email is required')]
    #[Assert\Email(message: 'The email "{{ value }}" is not a valid email.')]
    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [self::ROLE_USER];

    #[Assert\Length(
        min: 8,
        max: 50,
        minMessage: 'Password must be at least {{ limit }} characters long',
        maxMessage: 'Password cannot be longer than {{ limit }} characters'
    )]
    #[ORM\Column]
    private ?string $password = null;

    #[Assert\NotBlank(message: 'First name is required')]
    #[Assert\Length(max: 255, maxMessage: 'First name cannot be longer than {{ limit }} characters')]
    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[Assert\NotBlank(message: 'Last name is required')]
    #[Assert\Length(max: 255, maxMessage: 'Last name cannot be longer than {{ limit }} characters')]
    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    #[Assert\NotBlank(message: 'CIN is required')]
    #[Assert\Length(exactly: 8, exactMessage: 'CIN must be exactly {{ limit }} characters')]
    #[ORM\Column(length: 20, unique: true)]
    private ?string $cin = null;

    #[Assert\NotBlank(message: 'Address is required')]
    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[Assert\NotBlank(message: 'Phone number is required')]
    #[Assert\Regex(
        pattern: '/^[0-9]{8,15}$/',
        message: 'Phone number must be between 8 and 15 digits'
    )]
    #[ORM\Column(length: 15)]
    private ?string $numTel = null;

    #[Assert\NotBlank(message: 'Birth date is required')]
    #[Assert\Date(message: 'Invalid birth date format')]
    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $dateNaissance = null;

    #[Assert\NotBlank(message: 'Gender is required')]
    #[Assert\Choice(choices: ['Male', 'Female'], message: 'Choose a valid gender')]
    #[ORM\Column(length: 10)]
    private ?string $genre = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getRoles(): array
    {
        return array_unique($this->roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }

    public function eraseCredentials(): void
    {
        // Clear any temporary sensitive data if needed
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getCin(): ?string
    {
        return $this->cin;
    }

    public function setCin(string $cin): static
    {
        $this->cin = $cin;
        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;
        return $this;
    }

    public function getNumTel(): ?string
    {
        return $this->numTel;
    }

    public function setNumTel(string $numTel): static
    {
        $this->numTel = $numTel;
        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $dateNaissance): static
    {
        $this->dateNaissance = $dateNaissance;
        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): static
    {
        $this->genre = $genre;
        return $this;
    }
}
