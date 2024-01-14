<?php

namespace App\Repository;

use App\Entity\NewUsersEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<NewUsersEntity>
 *
 * @method NewUsersEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method NewUsersEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method NewUsersEntity[]    findAll()
 * @method NewUsersEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewUsersEntityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NewUsersEntity::class);
    }

//    /**
//     * @return NewUsersEntity[] Returns an array of NewUsersEntity objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('n.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?NewUsersEntity
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
