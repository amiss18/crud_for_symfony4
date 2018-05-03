<?php
/**
 *
 * Created by PhpStorm.
 * User: armel ( @armel.m )
 * Date: 16/11/17
 * Time: 15:16
 */
namespace App\Repository;
use App\Entity\Category;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;


class ProductRepository extends  EntityRepository {


    /**
     *  all products
     *
     * @param int           $pageNumber
     * @param int $limit    number per page
     * @return Paginator    limit per page
     */
    public function findProducts(int $pageNumber , int $limit  ) :Paginator{


       $qb = $this->createQueryBuilder('p')
           ->join('p.category','c')
           ->addSelect('c.name as cat, p.name,p.id,p.price,p.description')
                ->getQuery()
                ->setFirstResult(($pageNumber-1) * $limit) // On définit l'annonce à partir de laquelle commencer la liste
                // Ainsi que le nombre d'annonce à afficher sur une page
                ->setMaxResults($limit);


    return new Paginator( $qb, true);
    }

    /**
     * @param int $productId
     * @return mixed
     */
    public function findProductById(int $productId ) {

        return $this->createQueryBuilder('p')
                    ->select('c.name as cat, p.name,p.id,p.price,p.description')
                    ->join('p.category','c')
                    ->where('p.id=:id')

                    ->setParameter('id', $productId)
                    ->getQuery()
                    ->setMaxResults(1)
                    ->getSingleResult();
    }

}