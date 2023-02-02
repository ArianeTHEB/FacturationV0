<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PatientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PatientRepository::class)]
#[ApiResource]
class Patient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["getPatients"])]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    #[Groups(["getPatients"])]
    #[Assert\NotBlank(message:"Le nom est obligatoire")]
    private ?string $nom = null;

    #[ORM\Column(length: 150)]
    #[Groups(["getPatients"])]
    private ?string $prenom = null;

    #[ORM\Column]
    private ?int $telephone = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"L'adresse electronique est necessaire pour l'envoi de votre facture")]
    private ?string $adresse_mail = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_naissance = null;

    #[ORM\ManyToOne(inversedBy: 'patients')]
    #[Groups(["getPatients"])]
    private ?Praticien $praticien = null;


    // récupère la date et l'heure du rdv du patient
    #[ORM\OneToMany(mappedBy: 'rdvPatient', targetEntity: Rdv::class)]
    private Collection $rdvsPatient;

    #[ORM\OneToMany(mappedBy: 'patient', targetEntity: Facture::class)]
    private Collection $facturePatient;

    public function __construct()
    {
        $this->rdvsPatient = new ArrayCollection();
        $this->facturePatient = new ArrayCollection();
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

    public function getTelephone(): ?int
    {
        return $this->telephone;
    }

    public function setTelephone(int $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getAdresseMail(): ?string
    {
        return $this->adresse_mail;
    }

    public function setAdresseMail(string $adresse_mail): self
    {
        $this->adresse_mail = $adresse_mail;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->date_naissance;
    }

    public function setDateNaissance(?\DateTimeInterface $date_naissance): self
    {
        $this->date_naissance = $date_naissance;

        return $this;
    }

    public function getPraticien(): ?Praticien
    {
        return $this->praticien;
    }

    public function setPraticien(?Praticien $praticien): self
    {
        $this->praticien = $praticien;

        return $this;
    }

    /**
     * @return Collection<int, Rdv>
     */
    public function getRdvsPatient(): Collection
    {
        return $this->rdvsPatient;
    }

    public function addRdvsPatient(Rdv $rdvsPatient): self
    {
        if (!$this->rdvsPatient->contains($rdvsPatient)) {
            $this->rdvsPatient->add($rdvsPatient);
            $rdvsPatient->setRdvPatient($this);
        }

        return $this;
    }

    public function removeRdvsPatient(Rdv $rdvsPatient): self
    {
        if ($this->rdvsPatient->removeElement($rdvsPatient)) {
            // set the owning side to null (unless already changed)
            if ($rdvsPatient->getRdvPatient() === $this) {
                $rdvsPatient->setRdvPatient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Facture>
     */
    public function getFacturePatient(): Collection
    {
        return $this->facturePatient;
    }

    public function addFacturePatient(Facture $facturePatient): self
    {
        if (!$this->facturePatient->contains($facturePatient)) {
            $this->facturePatient->add($facturePatient);
            $facturePatient->setPatient($this);
        }

        return $this;
    }

    public function removeFacturePatient(Facture $facturePatient): self
    {
        if ($this->facturePatient->removeElement($facturePatient)) {
            // set the owning side to null (unless already changed)
            if ($facturePatient->getPatient() === $this) {
                $facturePatient->setPatient(null);
            }
        }

        return $this;
    }
}