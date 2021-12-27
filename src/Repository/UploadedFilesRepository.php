<?php

namespace App\Repository;

use App\Entity\UploadedFiles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UploadedFiles|null find($id, $lockMode = null, $lockVersion = null)
 * @method UploadedFiles|null findOneBy(array $criteria, array $orderBy = null)
 * @method UploadedFiles[]    findAll()
 * @method UploadedFiles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UploadedFilesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UploadedFiles::class);
    }

    public function getAll()
    {
        return $this->createQueryBuilder('u')
            ->orderBy('u.created_at', 'DESC')
            ->getQuery()
            ->getArrayResult();
    }


    /*
    public function findOneBySomeField($value): ?UploadedFiles
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
