<?php

namespace App\Repository;

use App\Entity\Person;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Person|null find($id, $lockMode = null, $lockVersion = null)
 * @method Person|null findOneBy(array $criteria, array $orderBy = null)
 * @method Person[]    findAll()
 * @method Person[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Person::class);
    }

    public function personExistsOnMovie($name, $surname, $title)
    {
        return (bool) $this->createQueryBuilder('p')
            ->andWhere('p.firstName = :name')
            ->setParameter('name', $name)
            ->andWhere('p.lastName = :surname')
            ->setParameter('surname', $surname)
            ->innerJoin('p.movies', 'm')
            ->andWhere('m.title = :title')
            ->setParameter('title', $title)
            ->getQuery()
            ->getResult();
    }
    public function personExists($name, $surname)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.firstName = :name')
            ->setParameter('name', $name)
            ->andWhere('p.lastName = :surname')
            ->setParameter('surname', $surname)
            ->getQuery()
            ->getResult();
    }
}
