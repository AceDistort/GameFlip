<?php

namespace App\Repository;

use App\Entity\ItemTrade;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ItemTrade>
 *
 * @method ItemTrade|null find($id, $lockMode = null, $lockVersion = null)
 * @method ItemTrade|null findOneBy(array $criteria, array $orderBy = null)
 * @method ItemTrade[]    findAll()
 * @method ItemTrade[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ItemTradeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ItemTrade::class);
    }

//    /**
//     * @return ItemTrade[] Returns an array of ItemTrade objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ItemTrade
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
