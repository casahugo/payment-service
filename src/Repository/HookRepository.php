<?php

namespace App\Repository;

use App\Entity\Hook;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Hook|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hook|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hook[]    findAll()
 * @method Hook[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Hook::class);
    }

    public function save(Hook $hook): Hook
    {
        $this->getEntityManager()->persist($hook);
        $this->getEntityManager()->flush($hook);
    }

    // /**
    //  * @return Hook[] Returns an array of Hook objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Hook
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
