<?php

namespace App\Entity;

use App\Entity\Traits\Timestampable;
use App\Repository\PersonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PersonRepository::class)
 * @ORM\Table(name="persons")
 * @ORM\HasLifecycleCallbacks
 */
class Person
{
    use Timestampable;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="First name should not be blank")
     * @Assert\Length(min=2)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Last name should not be blank")
     * @Assert\Length(min=2)
     */
    private $lastName;

    /**
     * @ORM\Column(type="date")
     * @Assert\Type("\DateTimeInterface",message="This is not a valid date")
     */
    private $dob;

    /**
     * @ORM\OneToMany(targetEntity=Role::class, mappedBy="person")
     */
    private $roles;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getDob(): ?\DateTimeInterface
    {
        return $this->dob;
    }

    public function setDob(\DateTimeInterface $dob): self
    {
        $this->dob = $dob;

        return $this;
    }

//    /**
//     * @return Collection|Movie[]
//     */
//    public function getMovies(): Collection
//    {
//        return $this->movies;
//    }
//
//    public function addMovie(Movie $movie): self
//    {
//        if (!$this->movies->contains($movie)) {
//            $this->movies[] = $movie;
//        }
//
//        return $this;
//    }
//
//    public function removeMovie(Movie $movie): self
//    {
//        if ($this->movies->contains($movie)) {
//            $this->movies->removeElement($movie);
//        }
//
//        return $this;
//    }

    /**
     * @return Collection|Role[]
     */
    public function getRoles(): Collection
    {
        return $this->roles;
    }

}
