<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function getArrayAllProducts(array $parameters)
    {
        $qb = $this->createQueryBuilder('p');

        if ($parameters['min']) {
            $qb
                ->andWhere('p.price > :min')
                ->setParameter('min', $parameters['min']);
        }

        if ($parameters['max']) {
            $qb
                ->andWhere('p.price < :max')
                ->setParameter('max', $parameters['max']);
        }

        return $qb
            ->getQuery()
            ->getArrayResult();
    }

    public function getProductById(int $id)
    {
        return $this->createQueryBuilder('p')
            ->where('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getArrayResult();
    }

    public function search(string $words)
    {
        return $this->createQueryBuilder('p')
            ->where('p.name LIKE :words')
            ->orWhere('p.description LIKE :words')
            ->setParameter('words', '%'.$words.'%')
            ->getQuery()
            ->getArrayResult();
    }

    // /**
    //  * @return Product[] Returns an array of Product objects
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
    public function findOneBySomeField($value): ?Product
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
