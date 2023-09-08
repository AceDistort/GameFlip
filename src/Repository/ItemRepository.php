<?php

namespace App\Repository;

use App\Entity\Item;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Item>
 *
 * @method Item|null find($id, $lockMode = null, $lockVersion = null)
 * @method Item|null findOneBy(array $criteria, array $orderBy = null)
 * @method Item[]    findAll()
 * @method Item[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Item::class);
    }

    public function findItemsByUser($userId): array
    {
        return $this->createQueryBuilder('item')
            ->select('item')
            ->innerJoin('item.game', 'game')
            ->innerJoin('item.user', 'user')
            ->where('user.id = :userId')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getResult();
    }

    public function findItemsByGame($gameId, $cityId): array
    {
        $query = $this->createQueryBuilder('item')
            ->select('item')
            ->innerJoin('item.game', 'game')
            ->where('item.available = true')
            ->where('game.id = :gameId')
            ->setParameter('gameId', $gameId);

        if ($cityId) {
            $query->innerJoin('item.user', 'user')
                ->innerJoin('user.city', 'city')
                ->andWhere('city.id = :cityId')
                ->setParameter('cityId', $cityId);
        };

        return $query->getQuery()
            ->getResult();
    }
}
