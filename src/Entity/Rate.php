<?php

namespace App\Entity;

use App\Repository\RateRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RateRepository::class)
 */
class Rate
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="rates")
     */
    private $userVoteur;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="rates")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userVote;

    /**
     * @ORM\Column(type="float")
     */
    private $etoile;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $commentaire;

    /**
     * @ORM\Column(type="date")
     */
    private $dateDePublication;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserVoteur(): ?User
    {
        return $this->userVoteur;
    }

    public function setUserVoteur(?User $userVoteur): self
    {
        $this->userVoteur = $userVoteur;

        return $this;
    }

    public function getUserVote(): ?User
    {
        return $this->userVote;
    }

    public function setUserVote(?User $userVote): self
    {
        $this->userVote = $userVote;

        return $this;
    }

    public function getEtoile(): ?float
    {
        return $this->etoile;
    }

    public function setEtoile(float $etoile): self
    {
        $this->etoile = $etoile;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getDateDePublication(): ?\DateTimeInterface
    {
        return $this->dateDePublication;
    }

    public function setDateDePublication(\DateTimeInterface $dateDePublication): self
    {
        $this->dateDePublication = $dateDePublication;

        return $this;
    }
}
