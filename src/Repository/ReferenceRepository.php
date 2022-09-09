<?php

namespace App\Repository;

use App\Entity\Reference;
use App\Entity\SearchReference;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reference>
 *
 * @method Reference|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reference|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reference[]    findAll()
 * @method Reference[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReferenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reference::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Reference $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Reference $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function findref(SearchReference $searchReference)
    {
        $query =  $this->createQueryBuilder('r');
        if($searchReference->getReferncepays())
        {
            $query = $query->andWhere('r.pays = :val')
                ->setParameter(':val', $searchReference->getReferncepays()->getPays());
        }
        if($searchReference->getReferencetitre())
        {
            $query = $query->andWhere('r.titre = :val1')
                ->setParameter(':val1', $searchReference->getReferencetitre()->getTitre());
        }
        if($searchReference->getRefernceclient())
        {
            $query = $query->andWhere('r.nomClient = :val2')
                ->setParameter(':val2', $searchReference->getRefernceclient()->getNomClient());
        }
        if($searchReference->getReferencedatedebut())
        {
            $query = $query->andWhere('r.datedebut > :min')
                ->setParameter(':min', $searchReference->getReferencedatedebut());
        }
        if($searchReference->getReferencedatefin())
        {
            $query = $query->andWhere('r.datefin < :max')
                ->setParameter(':max', $searchReference->getReferencedatefin());
        }
        return $query->getQuery()->getResult();
    }




    // /**
    //  * @return Reference[] Returns an array of Reference objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Reference
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
