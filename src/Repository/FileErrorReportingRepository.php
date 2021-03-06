<?php

namespace App\Repository;

use App\Entity\FileErrorReporting;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FileErrorReporting|null find($id, $lockMode = null, $lockVersion = null)
 * @method FileErrorReporting|null findOneBy(array $criteria, array $orderBy = null)
 * @method FileErrorReporting[]    findAll()
 * @method FileErrorReporting[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FileErrorReportingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FileErrorReporting::class);
    }

    // /**
    //  * @return FileErrorReporting[] Returns an array of FileErrorReporting objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FileErrorReporting
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
