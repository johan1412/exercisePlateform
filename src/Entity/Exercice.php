<?php

namespace App\Entity;

use App\Repository\ExerciceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=ExerciceRepository::class)
 */
class Exercice
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="array")
     * @Assert\NotNull
     */
    private $instructions = [];

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Cours::class, inversedBy="exercices")
     */
    private $cours;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInstructions(): ?array
    {
        return $this->instructions;
    }

    public function setInstructions(array $instructions): self
    {
        $this->instructions = $instructions;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCours(): ?Cours
    {
        return $this->cours;
    }

    public function setCours(?Cours $cours): self
    {
        $this->cours = $cours;

        return $this;
    }
}
