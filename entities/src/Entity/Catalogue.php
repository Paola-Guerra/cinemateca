<?php

namespace App\Entity;

use App\Repository\CatalogueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CatalogueRepository::class)]
class Catalogue
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $url = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created_date = null;

    #[ORM\ManyToOne]
    private ?categories $gender = null;

    #[ORM\ManyToMany(targetEntity: Categories::class, inversedBy: 'catalogues')]
    private Collection $Categories;

    #[ORM\ManyToMany(targetEntity: Gender::class, mappedBy: 'relation')]
    private Collection $genders;

    public function __construct()
    {
        $this->Categories = new ArrayCollection();
        $this->genders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function getCreatedDate(): ?\DateTimeInterface
    {
        return $this->created_date;
    }

    public function setCreatedDate(\DateTimeInterface $created_date): static
    {
        $this->created_date = $created_date;

        return $this;
    }

    public function getGender(): ?categories
    {
        return $this->gender;
    }

    public function setGender(?categories $gender): static
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * @return Collection<int, Categories>
     */
    public function getCategories(): Collection
    {
        return $this->Categories;
    }

    public function addCategory(Categories $category): static
    {
        if (!$this->Categories->contains($category)) {
            $this->Categories->add($category);
        }

        return $this;
    }

    public function removeCategory(Categories $category): static
    {
        $this->Categories->removeElement($category);

        return $this;
    }

    /**
     * @return Collection<int, Gender>
     */
    public function getGenders(): Collection
    {
        return $this->genders;
    }

    public function addGender(Gender $gender): static
    {
        if (!$this->genders->contains($gender)) {
            $this->genders->add($gender);
            $gender->addRelation($this);
        }

        return $this;
    }

    public function removeGender(Gender $gender): static
    {
        if ($this->genders->removeElement($gender)) {
            $gender->removeRelation($this);
        }

        return $this;
    }
}
