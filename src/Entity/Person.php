<?php

namespace App\Entity;

use App\Repository\PersonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PersonRepository::class)
 * @ORM\Table(name="persons")
 */
class Person
{
    const ROLES = ['actor', 'director', 'producer', 'other'];
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="First name should not be blank")
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Last name should not be blank")
     */
    private $lastName;

    /**
     * @ORM\Column(type="date")
     * @Assert\Date(message="This is not a valid date")
     */
    private $dob;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Choice(choices="Person::ROLES", message="This is not a valid role")
     */
    private $role;

    /**
     * @ORM\ManyToMany(targetEntity=Movie::class, inversedBy="people", cascade={"persist"})
     * @ORM\JoinTable(name="person_movie", joinColumns={
     @ORM\JoinColumn(name="person_id", referencedColumnName="id")
*     }, inverseJoinColumns={
     @ORM\JoinColumn(name="movie_id", referencedColumnName="id")
*     })
     */
    private $movies;

    public function __construct()
    {
        $this->movies = new ArrayCollection();
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

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @return Collection|Movie[]
     */
    public function getMovies(): Collection
    {
        return $this->movies;
    }

    public function addMovie(Movie $movie): self
    {
        if (!$this->movies->contains($movie)) {
            $this->movies[] = $movie;
        }

        return $this;
    }

    public function removeMovie(Movie $movie): self
    {
        if ($this->movies->contains($movie)) {
            $this->movies->removeElement($movie);
        }

        return $this;
    }
}
