<?php

namespace App\DataFixtures;

use App\Entity\Person;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PersonFixtures extends Fixture
{
    public const FIRST_PERSON = 'person1';
    public const SECOND_PERSON = 'person2';

    public function load(ObjectManager $manager)
    {
       $person1 = new Person();
       $person1->setFirstName("Ivan");
       $person1->setLastName("Kovač");
       $person1->setDob(new DateTime('2000-10-01'));
       $person1->setRole('actor');
       $manager->persist($person1);

        $person2 = new Person();
        $person2->setFirstName("Marko");
        $person2->setLastName("Maric");
        $person2->setDob(new DateTime("1994-08-12"));
        $person2->setRole('director');
        $manager->persist($person2);
        $manager->flush();
        $this->addReference(self::FIRST_PERSON, $person1);
        $this->addReference(self::SECOND_PERSON, $person2);
    }
}
