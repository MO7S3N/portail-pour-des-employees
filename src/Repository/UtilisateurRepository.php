<?php

namespace App\Repository;

use App\Entity\Search;
use App\Entity\Utilisateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Utilisateur>
 *
 * @method Utilisateur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Utilisateur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Utilisateur[]    findAll()
 * @method Utilisateur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UtilisateurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Utilisateur::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Utilisateur $entity, bool $flush = true): void
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
    public function remove(Utilisateur $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Utilisateur[] Returns an array of Utilisateur objects
    //  */

    public function findconsultants(Search $search)
    {
        $query =  $this->createQueryBuilder('u')
            ->where('u.roles = :val')
            ->setParameter('val', '[ROLE_CONSULTANTS]');
        if ($search->getRefernce()->count() > 0)
        {
            foreach ($search->getRefernce() as $k => $references)
            {
                $query = $query
                    ->andWhere(":reference$k MEMBER OF u.reference")
                    ->setParameter("reference$k" , $references);
            }
        }
        return $query->getQuery()->getResult();


    }

    public function findadmins()
    {
        return $this->createQueryBuilder('u')
            ->where('u.roles = :val')
            ->setParameter('val', '[ROLE_ADMIN]')
            ->getQuery()
            ->getResult()
            ;
    }

    public function countreferences($user)
    {
         return $this->createQueryBuilder('u')
            ->where('u.id = :val')
            ->setParameter('val' , $user)
             ->select('SIZE(u.reference)')
            ->getQuery()
            ->getSingleScalarResult();

    }

    public function findUtilisateurbyname($name)
    {
        return $this->createQueryBuilder('u')
            ->where('u.nom LIKE :name')
            ->setParameter('name', '%'.$name.'%')
            ->andWhere('u.roles = :val')
            ->setParameter('val' , '[ROLE_CONSULTANTS]')
            ->getQuery()
            ->getResult();
    }




    /*
    public function findOneBySomeField($value): ?Utilisateur
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
