<?php

namespace App\Entity;

use App\Repository\MessengerRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MessengerRepository::class)
 */
class Messenger
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isRead = 0;

    /**
     * @ORM\Column(type="text")
     */
    private $contenue;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="yes")
     */
    private $envoyeur;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="yes")
     */
    private $recepteur;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    public function __construct(){
$this->date=new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsRead(): ?bool
    {
        return $this->isRead;
    }

    public function setIsRead(?bool $isRead): self
    {
        $this->isRead = $isRead;

        return $this;
    }

    public function getContenue(): ?string
    {
        return $this->contenue;
    }

    public function setContenue(?string $contenue): self
    {
        $this->contenue = $contenue;

        return $this;
    }

    public function getEnvoyeur(): ?User
    {
        return $this->envoyeur;
    }

    public function setEnvoyeur(?User $envoyeur): self
    {
        $this->envoyeur = $envoyeur;

        return $this;
    }

    public function getRecepteur(): ?User
    {
        return $this->recepteur;
    }

    public function setRecepteur(?User $recepteur): self
    {
        $this->recepteur = $recepteur;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
