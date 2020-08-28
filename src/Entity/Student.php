<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Student extends User
{

    /**
     * @ORM\ManyToMany(targetEntity=Cours::class, inversedBy="students")
     */
    private $cours;

    /**
     * @ORM\OneToMany(targetEntity=Stats::class, mappedBy="student", orphanRemoval=true)
     */
    private $stats;

    public function __construct()
    {
        $this->cours = new ArrayCollection();
        $this->setRoles(["ROLE_STUDENT", "ROLE_USER"]);
        $this->stats = new ArrayCollection();
    }

    /**
     * @return Collection|Cours[]
     */
    public function getCours(): Collection
    {
        return $this->cours;
    }

    public function addCour(Cours $cour): self
    {
        if (!$this->cours->contains($cour)) {
            $this->cours[] = $cour;
        }

        return $this;
    }

    public function removeCour(Cours $cour): self
    {
        if ($this->cours->contains($cour)) {
            $this->cours->removeElement($cour);
        }

        return $this;
    }

    /**
     * @return Collection|Stats[]
     */
    public function getStats(): Collection
    {
        return $this->stats;
    }

    public function addStat(Stats $stat): self
    {
        if (!$this->stats->contains($stat)) {
            $this->stats[] = $stat;
            $stat->setStudent($this);
        }

        return $this;
    }

    public function removeStat(Stats $stat): self
    {
        if ($this->stats->contains($stat)) {
            $this->stats->removeElement($stat);
            // set the owning side to null (unless already changed)
            if ($stat->getStudent() === $this) {
                $stat->setStudent(null);
            }
        }

        return $this;
    }

}
