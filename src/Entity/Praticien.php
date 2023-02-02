<?php

namespace App\Entity;

use App\Repository\PraticienRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PraticienRepository::class)]
class Praticien
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["getPatients"])]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    #[Groups(["getPatients"])]
    private ?string $nom = null;

    #[ORM\Column(length: 150)]
    #[Groups(["getPatients"])]
    private ?string $prenom = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(["getPatients"])]
    private ?string $adresse = null;

    #[ORM\Column]
    #[Groups(["getPatients"])]
    private ?int $telephone = null;

    #[ORM\Column]
    #[Groups(["getPatients"])]
    private ?int $Adeli = null;


//récupère tous les patients
    #[ORM\OneToMany(mappedBy: 'praticien', targetEntity: Patient::class)]
    private Collection $patients;
    private $patient=null;

    #[ORM\OneToMany(mappedBy: 'rdvPraticien', targetEntity: Rdv::class)]
    private Collection $rdvsPraticien;

    #[ORM\OneToMany(mappedBy: 'praticien', targetEntity: Facture::class)]
    private Collection $facturePraticien;


    public function __construct()
    {
        $this->patients = new ArrayCollection();
        $this->rdvsPraticien = new ArrayCollection();
        $this->facturePraticien = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTelephone(): ?int
    {
        return $this->telephone;
    }

    public function setTelephone(int $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getAdeli(): ?int
    {
        return $this->Adeli;
    }

    public function setAdeli(int $Adeli): self
    {
        $this->Adeli = $Adeli;

        return $this;
    }

  //  /**
  //   * @return Collection<int, Patient>
  //   */
    public function getPatients(): ?Patient
    {
        return $this->patient;
    }

    public function addPatient(Patient $patient): self
    {
        if (!$this->patients->contains($patient)) {
            $this->patients->add($patient);
            $patient->setPraticien($this);
        }

        return $this;
    }

    public function removePatient(Patient $patient): self
    {
        if ($this->patients->removeElement($patient)) {
            // set the owning side to null (unless already changed)
            if ($patient->getPraticien() === $this) {
                $patient->setPraticien(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Rdv>
     */
    public function getRdvsPraticien(): Collection
    {
        return $this->rdvsPraticien;
    }

    public function addRdvsPraticien(Rdv $rdvsPraticien): self
    {
        if (!$this->rdvsPraticien->contains($rdvsPraticien)) {
            $this->rdvsPraticien->add($rdvsPraticien);
            $rdvsPraticien->setRdvPraticien($this);
        }

        return $this;
    }

    public function removeRdvsPraticien(Rdv $rdvsPraticien): self
    {
        if ($this->rdvsPraticien->removeElement($rdvsPraticien)) {
            // set the owning side to null (unless already changed)
            if ($rdvsPraticien->getRdvPraticien() === $this) {
                $rdvsPraticien->setRdvPraticien(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Facture>
     */
    public function getFacturePraticien(): Collection
    {
        return $this->facturePraticien;
    }

    public function addFacturePraticien(Facture $facturePraticien): self
    {
        if (!$this->facturePraticien->contains($facturePraticien)) {
            $this->facturePraticien->add($facturePraticien);
            $facturePraticien->setPraticien($this);
        }

        return $this;
    }

    public function removeFacturePraticien(Facture $facturePraticien): self
    {
        if ($this->facturePraticien->removeElement($facturePraticien)) {
            // set the owning side to null (unless already changed)
            if ($facturePraticien->getPraticien() === $this) {
                $facturePraticien->setPraticien(null);
            }
        }

        return $this;
    }

}
