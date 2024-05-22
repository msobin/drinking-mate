<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Mate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class MateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Mate::class);
    }

    public function findNearBy(Mate $mate, int $distance = 1000): array
    {
        $query = $this->createQueryBuilder('m')
            ->select('m')
            ->andWhere('ST_Distance(m.point, :point) <= :distance')
            ->andWhere('m.id != :id')
            ->andWhere('m.status = :status')
            ->setParameter('point', $mate->getPoint())
            ->setParameter('distance', $distance)
            ->setParameter('id', $mate->getId()->toString())
            ->setParameter('status', Mate::STATUS_ACTIVE)
            ->getQuery();

        return $query->getResult();
    }

    public function deactivate(int $mateTtl): void
    {
        $query = $this->createQueryBuilder('m')
            ->update()
            ->set('m.status', Mate::STATUS_INACTIVE)
            ->andWhere('m.lastActiveAt < :ts')
            ->andWhere('m.status = :status')
            ->setParameter('ts', time() - $mateTtl)
            ->setParameter('status', Mate::STATUS_INACTIVE)
            ->getQuery();

        $query->execute();
    }
}
