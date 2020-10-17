<?php

namespace App\DataFixtures;

use App\Entity\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class RoleFixtures extends Fixture implements DependentFixtureInterface
{
    public const FIRST_MOVIE = 'movie1';
    public const SECOND_MOVIE = 'movie2';
    public function load(ObjectManager $manager)
    {
        $role1 = new Role();
        $role1->setRole('actor');
        $role1->addMovie($this->getReference(MovieFixtures::FIRST_MOVIE));
        $role1->setPerson($this->getReference(PersonFixtures::FIRST_PERSON));
        $manager->persist($role1);

        $role2 = new Role();
        $role2->setRole('director');
        $role2->addMovie($this->getReference(MovieFixtures::SECOND_MOVIE));
        $role2->setPerson($this->getReference(PersonFixtures::SECOND_PERSON));
        $manager->persist($role2);
        $manager->flush();
    }
    public function getDependencies()
    {
        return [MovieFixtures::class];
    }
}
