<?php

namespace App\Repository;

use App\Entity\TaskRecord;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TaskRecord>
 *
 * @method TaskRecord|null find($id, $lockMode = null, $lockVersion = null)
 * @method TaskRecord|null findOneBy(array $criteria, array $orderBy = null)
 * @method TaskRecord[]    findAll()
 * @method TaskRecord[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskRecordRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TaskRecord::class);
    }

//    /**
//     * @return TaskRecord[] Returns an array of TaskRecord objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TaskRecord
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
