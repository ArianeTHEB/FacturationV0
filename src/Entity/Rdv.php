<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\RdvRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: RdvRepository::class)]
#[ApiResource]
class Rdv
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["getPatients"])]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(["getPatients"])]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column]
    #[Groups(["getPatients"])]
    private ?int $montant = null;

    #[ORM\ManyToOne(inversedBy: 'rdvsPatient')]
    #[Groups(["getPatients"])]
    private ?Patient $rdvPatient = null;

    #[ORM\ManyToOne(inversedBy: 'rdvsPraticien')]
    private ?Praticien $rdvPraticien = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(int $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getRdvPatient(): ?Patient
    {
        return $this->rdvPatient;
    }

    public function setRdvPatient(?Patient $rdvPatient): self
    {
        $this->rdvPatient = $rdvPatient;

        return $this;
    }

    public function getRdvPraticien(): ?Praticien
    {
        return $this->rdvPraticien;
    }

    public function setRdvPraticien(?Praticien $rdvPraticien): self
    {
        $this->rdvPraticien = $rdvPraticien;

        return $this;
    }
}
