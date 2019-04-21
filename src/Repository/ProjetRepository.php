<?php

namespace App\Repository;

use App\Entity\Projet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Projet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Projet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Projet[]    findAll()
 * @method Projet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjetRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Projet::class);
    }

    public function ProjetEnCours()
    {
        return $this
            ->createQueryBuilder('p')
            ->select('COUNT(p.livre)')
            ->where('p.livre = \'NON\'')
            ->getQuery()
            ->getSingleScalarResult();
    }


    public function ProjetTermine()
    {
        return $this
            ->createQueryBuilder('p')
            ->select('COUNT(p.livre)')
            ->where('p.livre = \'OUI\'')
            ->getQuery()
            ->getSingleScalarResult();
    }


    public function TauxLivre1()
    {
        return $this
            ->createQueryBuilder('p')
            ->select('COUNT(p.livre)*100')
            ->where('p.livre = :oui')
            ->setParameter('oui', 'OUI')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function TauxLivre2()
    {
        return $this
            ->createQueryBuilder('p')
            ->select('COUNT(p.livre)')
            ->getQuery()
            ->getSingleScalarResult();
    }


    public function Search(string $query)
    {
        return $this
            ->createQueryBuilder('p')
            ->where('p.intitule LIKE :query')
            ->orWhere('p.description LIKE :query')
            ->setParameter('query', '%'.$query.'%')
            ->getQuery()
            ->getResult();
    }


    // /**
    //  * @return Projet[] Returns an array of Projet objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Projet
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
