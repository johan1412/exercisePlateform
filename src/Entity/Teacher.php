<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Teacher extends User
{

    /**
     * @ORM\OneToMany(targetEntity=Cours::class, mappedBy="teacher")
     */
    private $cours;

    public function __construct()
    {
        $this->cours = new ArrayCollection();
        $this->setRoles(["ROLE_TEACHER", "ROLE_USER"]);
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
            $cour->setTeacher($this);
        }

        return $this;
    }

    public function removeCour(Cours $cour): self
    {
        if ($this->cours->contains($cour)) {
            $this->cours->removeElement($cour);
            // set the owning side to null (unless already changed)
            if ($cour->getTeacher() === $this) {
                $cour->setTeacher(null);
            }
        }

        return $this;
    }

}
