<?php

namespace App\Entity;

use App\Repository\PlanteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlanteRepository::class)]
class Plante
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $notes = null;

    #[ORM\Column(length: 255)]
    private ?string $arrosageStr = null;

    #[ORM\Column]
    private ?int $nombre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $bouturage = null;

    #[ORM\ManyToOne(inversedBy: 'plantes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Luminosite $luminosite = null;

    #[ORM\ManyToOne(inversedBy: 'plantes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'plante', targetEntity: Photo::class, orphanRemoval: true)]
    private Collection $photos;

    #[ORM\Column]
    private ?int $arrosageNb = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nomLatin = null;

    #[ORM\Column(nullable: true)]
    private array $particularites = [];

    public function __construct()
    {
        $this->photos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): static
    {
        $this->notes = $notes;

        return $this;
    }

    public function getArrosageStr(): ?string
    {
        return $this->arrosageStr;
    }

    public function setArrosageStr(string $arrosageStr): static
    {
        $this->arrosageStr = $arrosageStr;

        return $this;
    }

    public function getNombre(): ?int
    {
        return $this->nombre;
    }

    public function setNombre(int $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getBouturage(): ?string
    {
        return $this->bouturage;
    }

    public function setBouturage(?string $bouturage): static
    {
        $this->bouturage = $bouturage;

        return $this;
    }

    public function getLuminosite(): ?Luminosite
    {
        return $this->luminosite;
    }

    public function setLuminosite(?Luminosite $luminosite): static
    {
        $this->luminosite = $luminosite;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Photo>
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(Photo $photo): static
    {
        if (!$this->photos->contains($photo)) {
            $this->photos->add($photo);
            $photo->setPlante($this);
        }

        return $this;
    }

    public function removePhoto(Photo $photo): static
    {
        if ($this->photos->removeElement($photo)) {
            // set the owning side to null (unless already changed)
            if ($photo->getPlante() === $this) {
                $photo->setPlante(null);
            }
        }

        return $this;
    }

    public function getArrosageNb(): ?int
    {
        return $this->arrosageNb;
    }

    public function setArrosageNb(int $arrosageNb): static
    {
        $this->arrosageNb = $arrosageNb;

        return $this;
    }

    public function getNomLatin(): ?string
    {
        return $this->nomLatin;
    }

    public function setNomLatin(?string $nomLatin): static
    {
        $this->nomLatin = $nomLatin;

        return $this;
    }

    public function getParticularites(): array
    {
        return $this->particularites;
    }

    public function setParticularites(?array $particularites): static
    {
        $this->particularites = $particularites;

        return $this;
    }
}
