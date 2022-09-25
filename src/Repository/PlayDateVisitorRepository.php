<?php

namespace App\Repository;

use App\Entity\PlayDateVisitor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PlayDateVisitor>
 *
 * @method PlayDateVisitor|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlayDateVisitor|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlayDateVisitor[]    findAll()
 * @method PlayDateVisitor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlayDateVisitorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlayDateVisitor::class);
    }

    public function add(PlayDateVisitor $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PlayDateVisitor $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return PlayDateVisitor[] Returns an array of PlayDateVisitor objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PlayDateVisitor
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
