<?php

namespace App\Repository;

use App\Entity\Annonce;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Query\Expr\OrderBy;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Annonce|null find($id, $lockMode = null, $lockVersion = null)
 * @method Annonce|null findOneBy(array $criteria, array $orderBy = null)
 * @method Annonce[]    findAll()
 * @method Annonce[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnnonceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Annonce::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Annonce $entity, bool $flush = true): void
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
    public function remove(Annonce $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
      /**
     * Recherche les annonces en fonction du formulaire
     * @return void 
     */
    public function search($mots = null, $categorie = null){
        $query = $this->createQueryBuilder('a');
        if($mots != null){
            $query->andWhere('MATCH_AGAINST(a.titre, a.contenue) AGAINST (:mots boolean)>0')
                ->setParameter('mots', $mots);
        }
        if($categorie != null){
            $query->leftJoin('a.categorie', 'c');
            $query->andWhere('c.id = :id')
                ->setParameter('id', $categorie);
        }
        return $query->getQuery()->getResult();
    }

    public function getPaginatedAnnonce($page, $limite, $user = null)
    {

        $query = $this->createQueryBuilder('a')
            ->where('a.user = :id')
            ->OrderBy('a.dateDePublication')
            ->setFirstResult(($page * $limite) - $limite)
            ->setMaxResults($limite)
            ->setParameter('id', $user);
        return $query->getQuery()->getResult();
    }
    public function getAllAnnonces($user = null)
    {
        $query = $this->createQueryBuilder('a')
            ->select('COUNT(a)')
            ->where('a.user = :id')
            ->setParameter('id', $user);
        return $query->getQuery()->getSingleScalarResult();
    }
    public function pagination($page, $limite)
    {
        $query = $this->createQueryBuilder('a')
            ->OrderBy('a.dateDePublication')
            ->setFirstResult(($page * $limite) - $limite)
            ->setMaxResults($limite);
        return $query->getQuery()->getResult();
    }
    public function tousLesAnnonces()
    {
        $query = $this->createQueryBuilder('a')
            ->select('COUNT(a)');
        return $query->getQuery()->getSingleScalarResult();
    }
    
    // /**
    //  * @return Annonce[] Returns an array of Annonce objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Annonce
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}