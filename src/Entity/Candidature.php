<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CandidatureRepository;

/**
 * @ORM\Entity(repositoryClass=CandidatureRepository::class)
 */
class Candidature
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="candidatures")
     * @ORM\JoinColumn(nullable=false)
     */
    private $apprenant;

    /**
     * @ORM\ManyToOne(targetEntity=Entreprise::class, inversedBy="candidatures")
     * @ORM\JoinColumn(nullable=false)
     */
    private $entreprise;

    /**
     * @ORM\Column(type="datetime")
     */
    private $requestDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $relanceDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $meetingDate;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getApprenant(): ?User
    {
        return $this->apprenant;
    }

    public function setApprenant(?User $apprenant): self
    {
        $this->apprenant = $apprenant;

        return $this;
    }

    public function getEntreprise(): ?Entreprise
    {
        return $this->entreprise;
    }

    public function setEntreprise(?Entreprise $entreprise): self
    {
        $this->entreprise = $entreprise;

        return $this;
    }

    public function getRequestDate(): ?\DateTimeInterface
    {
        return $this->requestDate;
    }

    public function setRequestDate(\DateTimeInterface $requestDate): self
    {
        $this->requestDate = $requestDate;

        return $this;
    }

    public function getRelanceDate(): ?\DateTimeInterface
    {
        return $this->relanceDate;
    }

    public function setRelanceDate(?\DateTimeInterface $relanceDate): self
    {
        $this->relanceDate = $relanceDate;

        return $this;
    }

    public function getMeetingDate(): ?\DateTimeInterface
    {
        return $this->meetingDate;
    }

    public function setMeetingDate(?\DateTimeInterface $meetingDate): self
    {
        $this->meetingDate = $meetingDate;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }
}
