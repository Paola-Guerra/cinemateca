<?php

namespace App\Entity;

use App\Repository\GenderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GenderRepository::class)]
class Gender
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $terror = null;

    #[ORM\Column(length: 255)]
    private ?string $suspense = null;

    #[ORM\Column(length: 255)]
    private ?string $comedy = null;

    #[ORM\Column(length: 255)]
    private ?string $cartoon = null;

    #[ORM\Column(length: 255)]
    private ?string $anime = null;

    #[ORM\Column(length: 255)]
    private ?string $drama = null;

    #[ORM\ManyToMany(targetEntity: Catalogue::class, inversedBy: 'genders')]
    private Collection $relation;

    public function __construct()
    {
        $this->relation = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTerror(): ?string
    {
        return $this->terror;
    }

    public function setTerror(string $terror): static
    {
        $this->terror = $terror;

        return $this;
    }

    public function getSuspense(): ?string
    {
        return $this->suspense;
    }

    public function setSuspense(string $suspense): static
    {
        $this->suspense = $suspense;

        return $this;
    }

    public function getComedy(): ?string
    {
        return $this->comedy;
    }

    public function setComedy(string $comedy): static
    {
        $this->comedy = $comedy;

        return $this;
    }

    public function getCartoon(): ?string
    {
        return $this->cartoon;
    }

    public function setCartoon(string $cartoon): static
    {
        $this->cartoon = $cartoon;

        return $this;
    }

    public function getAnime(): ?string
    {
        return $this->anime;
    }

    public function setAnime(string $anime): static
    {
        $this->anime = $anime;

        return $this;
    }

    public function getDrama(): ?string
    {
        return $this->drama;
    }

    public function setDrama(string $drama): static
    {
        $this->drama = $drama;

        return $this;
    }

    /**
     * @return Collection<int, Catalogue>
     */
    public function getRelation(): Collection
    {
        return $this->relation;
    }

    public function addRelation(Catalogue $relation): static
    {
        if (!$this->relation->contains($relation)) {
            $this->relation->add($relation);
        }

        return $this;
    }

    public function removeRelation(Catalogue $relation): static
    {
        $this->relation->removeElement($relation);

        return $this;
    }
}
