<?php
/**
 *  * Created by PhpStorm.
 * User: armel ( @armel.m )
 * Date: 23/11/17
 * Time: 14:59
 *
 */

namespace App\Service;


use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class ProductServ {
    private $logger;
    private $em;

    /**
     * ProductServ constructor.
     * @param LoggerInterface $logger
     * @param EntityManagerInterface $em
     */
    public function __construct(LoggerInterface $logger, EntityManagerInterface $em ) {
        $this->logger = $logger;
        $this->em     = $em;
    }

    /**
     *  delete product
     * @param Product $product
     * @throws \Exception
     */
    public function deleteProduct(Product $product ){
        if( !$product ) throw  new \Exception("entity does not exist");
        $this->em->remove($product);
        $this->em->flush();
        $this->logger->info("=====> product number {$product->getId()} is delete");
    }

}