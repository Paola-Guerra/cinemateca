<?php

namespace App\Entity;

use App\Repository\CategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoriesRepository::class)]
class Categories
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $movies = null;

    #[ORM\Column(length: 255)]
    private ?string $series = null;

    #[ORM\Column(length: 255)]
    private ?string $documentals = null;

    #[ORM\ManyToMany(targetEntity: Catalogue::class, mappedBy: 'Categories')]
    private Collection $catalogues;

    public function __construct()
    {
        $this->catalogues = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMovies(): ?string
    {
        return $this->movies;
    }

    public function setMovies(string $movies): static
    {
        $this->movies = $movies;

        return $this;
    }

    public function getSeries(): ?string
    {
        return $this->series;
    }

    public function setSeries(string $series): static
    {
        $this->series = $series;

        return $this;
    }

    public function getDocumentals(): ?string
    {
        return $this->documentals;
    }

    public function setDocumentals(string $documentals): static
    {
        $this->documentals = $documentals;

        return $this;
    }

    /**
     * @return Collection<int, Catalogue>
     */
    public function getCatalogues(): Collection
    {
        return $this->catalogues;
    }

    public function addCatalogue(Catalogue $catalogue): static
    {
        if (!$this->catalogues->contains($catalogue)) {
            $this->catalogues->add($catalogue);
            $catalogue->addCategory($this);
        }

        return $this;
    }

    public function removeCatalogue(Catalogue $catalogue): static
    {
        if ($this->catalogues->removeElement($catalogue)) {
            $catalogue->removeCategory($this);
        }

        return $this;
    }
}
