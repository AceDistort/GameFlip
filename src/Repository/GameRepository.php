<?php

namespace App\Repository;

use App\Entity\Game;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Game>
 *
 * @method Game|null find($id, $lockMode = null, $lockVersion = null)
 * @method Game|null findOneBy(array $criteria, array $orderBy = null)
 * @method Game[]    findAll()
 * @method Game[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Game::class);
    }

    /**
     * @return Game[] Returns an array of Game objects
     */
    public function findAvailableGamesByCity($cityId, $available): array
    {
        $query = $this->createQueryBuilder('game')
            ->select('DISTINCT game')
            ->innerJoin('game.items', 'item')
            ->innerJoin('item.user', 'user')
            ->innerJoin('user.city', 'city')
            ->where('city.id = :cityId')
            ->setParameter('cityId', $cityId);

        if ($available) {
            $query->andWhere('item.available = :available')
                ->setParameter('available', true);
        }

        return $query->setMaxResults(40)
            ->getQuery()
            ->getResult();
    }
}
