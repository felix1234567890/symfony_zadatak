<?php

namespace App\Repository;

use App\Entity\Movie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Movie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Movie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Movie[]    findAll()
 * @method Movie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Movie::class);
    }

    public function findAllQueryBuilder()
    {
        return $this->createQueryBuilder('m');
    }

    public function personExistsOnMovie($name, $surname, $title)
    {
        return (bool) $this->createQueryBuilder('m')
            ->andWhere('m.title = :title')
            ->setParameter('title', $title)
            ->innerJoin('m.roles', 'r')
            ->innerJoin('r.person', 'p')
            ->andWhere('p.firstName = :firstName')
            ->setParameter('firstName', $name)
            ->andWhere('p.lastName = :lastName')
            ->setParameter('lastName', $surname)
            ->getQuery()
            ->getResult();
    }
}
