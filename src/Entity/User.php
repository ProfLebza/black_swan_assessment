<?php

namespace App\Entity;

use App\Entity\Traits\EntityDatesTrait;
use App\Entity\Traits\EntityIdTrait;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use function json_encode;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`users`")
 */
class User implements UserInterface
{
    use EntityIdTrait, EntityDatesTrait;


    /**
     * @var string
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=180)
     * @Assert\Email()
     */
    private $email;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=50)
     * @Assert\LessThanOrEqual(50)
     */
    private $firstName;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=180)
     * @Assert\LessThanOrEqual(50)
     */
    private $lastName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="roles", type="string", length=255, nullable=true)
     */
    protected $roles;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */

    private $apiToken;

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     * @return User
     */
    public function setEmail(?string $email): User
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string|null $firstName
     * @return User
     */
    public function setFirstName(?string $firstName): User
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string|null $lastName
     * @return User
     */
    public function setLastName(?string $lastName): User
    {
        $this->lastName = $lastName;
        return $this;
    }


    /**
     * Set roles
     *
     * @param array|string|null $roles
     *
     * @return User
     */
    public function setRoles($roles = null): User
    {
        if (!is_array($roles)) {
            $roles = [$roles];
        }
        $this->roles = json_encode($roles);
        return $this;
    }

    /**
     * Get roles
     *
     * @return array|null
     */
    public function getRoles(): ?array
    {
        return json_decode($this->roles, true);
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getApiToken(): ?string
    {
        return $this->apiToken;
    }

    /**
     * @param string|null $apiToken
     * @return User
     */
    public function setApiToken(?string $apiToken): User
    {
        $this->apiToken = $apiToken;
        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}
