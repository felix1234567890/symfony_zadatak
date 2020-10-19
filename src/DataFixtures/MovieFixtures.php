<?php

namespace App\DataFixtures;

use App\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class MovieFixtures extends Fixture implements DependentFixtureInterface
{
    public const FIRST_MOVIE = 'movie1';
    public const SECOND_MOVIE = 'movie2';
    public function load(ObjectManager $manager)
    {
        $movie1 = new Movie();
        $movie1->setTitle('Moj prvi film');
        $movie1->setDescription("Ovo je opis mog prvog filma.Ovo pišem samo da ima nešto teksta");
        $movie1->setReleaseYear(2006);
        $manager->persist($movie1);

        $movie2 = new Movie();
        $movie2->setTitle('Titanic');
        $movie2->setDescription("Film govori o prvom i posljednjem putovanju tada najvećeg parobroda na svijetu koji je udario u santu leda i potopio se");
        $movie2->setReleaseYear(1997);
        $manager->persist($movie2);
        $manager->flush();
        $this->addReference(self::FIRST_MOVIE, $movie1);
        $this->addReference(self::SECOND_MOVIE, $movie2);
    }
public function getDependencies()
{
    return [PersonFixtures::class];
}
}
