<?php

namespace App\Repository;

use App\Entity\Grades;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Grades|null find($id, $lockMode = null, $lockVersion = null)
 * @method Grades|null findOneBy(array $criteria, array $orderBy = null)
 * @method Grades[]    findAll()
 * @method Grades[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GradesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Grades::class);
    }

    // /**
    //  * @return Grades[] Returns an array of Grades objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    public function findByStudentId($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.student = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
        ;
    }
}
