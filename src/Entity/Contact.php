<?php

namespace App\Entity;

use App\Entity\Traits\EntityDatesTrait;
use App\Entity\Traits\EntityIdTrait;
use App\Repository\ContactRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ContactRepository::class)
 * @ORM\Table(name="contacts")
 */
class Contact
{
    use EntityIdTrait, EntityDatesTrait;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min=3,
     *     max=50,
     *     minMessage="Your name needs to be at least 2 characters long",
     *     maxMessage="Your name shouldn't be more than 50 characters long"
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=180)
     * @Assert\NotBlank()
     * @Assert\Email()
     * @Assert\Length(
     *     min=5,
     *     max=180,
     *     minMessage="Your email needs to be at least 5 characters long",
     *     maxMessage="Your email shouldn't be more than 180 characters long"
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min=5,
     *     max=255,
     *     minMessage="Your message needs to be at least 5 characters long",
     *     maxMessage="Your message shouldn't be more than 255 characters long"
     * )
     */
    private $message;



    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'email' => $this->getEmail(),
            'message' => $this->getMessage(),
            'date_created' => $this->getDateCreated()
        ];
    }

}
