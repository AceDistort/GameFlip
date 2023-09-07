<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Rollerworks\Component\PasswordStrength\Validator\Constraints as RollerworksPassword;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\Email(message: 'The email {{ value }} is not a valid email.')]
    #[Assert\NotBlank(message: 'The email cannot be blank.')]
    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[RollerworksPassword\PasswordRequirements(
        minLength: 8,
        requireLetters: true,
        requireCaseDiff: true,
        requireNumbers: true,
        requireSpecialCharacter: true,
        tooShortMessage: 'Your password must be at least {{length}} characters long',
        missingLettersMessage: 'Your password must contain at least one letter',
        requireCaseDiffMessage: 'Your password must contain lowercase and uppercase letters',
        missingNumbersMessage: 'Your password must contain at least one number',
        missingSpecialCharacterMessage: 'Your password must contain at least one special character',
    )]
    #[Assert\NotBlank(message: 'Please enter a password.')]
    #[ORM\Column]
    private ?string $password = null;

    #[Assert\Length(
        min: 3,
        max: 30,
        minMessage: 'The first name must be at least {{ limit }} characters long',
        maxMessage: 'The first name cannot be longer than {{ limit }} characters'
    )]
    #[Assert\NotBlank(message: 'The first name cannot be blank.')]
    #[ORM\Column(length: 30)]
    private ?string $firstName = null;

    #[Assert\Length(
        min: 3,
        max: 30,
        minMessage: 'The last name must be at least {{ limit }} characters long',
        maxMessage: 'The last name cannot be longer than {{ limit }} characters'
    )]
    #[Assert\NotBlank(message: 'The last name cannot be blank.')]
    #[ORM\Column(length: 30)]
    private ?string $lastName = null;

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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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
}
