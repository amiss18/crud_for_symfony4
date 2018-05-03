<?php
/**
 *  * Created by PhpStorm.
 * User: armel ( @armel.m )
 * Date: 16/11/17
 * Time: 15:37
 */

namespace App\DataFixtures\ORM;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Tests\Fixtures\Validation\Category;

class LoadProduct extends Fixture {

    const DESCRIPTION = "
        ++Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias aperiam eos minima recusandae sequi, similique. Amet aperiam fuga rem sint sit. Alias necessitatibus quos recusandae sequi similique totam ut, velit.
         Alias necessitatibus
    ";

    public function load(ObjectManager $manager) {

        //category 1
        for ($i = 0; $i <= 8; $i++) {
            $product = new Product();
            $category = new Category();
            $product->setName("Product $i");
            $product->setPrice(mt_rand(15, 1000));
            $product->setDescription(self::DESCRIPTION);
            $product->setCategory($this->getReference('0'));
            $manager->persist($product);
        }

        //category 2
        for ($i = 9; $i <= 16; $i++) {
            $product = new Product();
            $category = new Category();
            $product->setName("Product $i");
            $product->setPrice(mt_rand(15, 1000));
            $product->setDescription(self::DESCRIPTION);
            $product->setCategory($this->getReference('1'));
            $manager->persist($product);
        }
        //category 3
        for ($i = 17; $i <= 24; $i++) {
            $product = new Product();
            $category = new Category();
            $product->setName("Product $i");
            $product->setPrice(mt_rand(5, 100));
            $product->setDescription(self::DESCRIPTION);
            $product->setCategory($this->getReference('2'));
            $manager->persist($product);
        }
        //category 3
        for ($i = 25; $i <= 32; $i++) {
            $product = new Product();
            $category = new Category();
            $product->setName("Product $i");
            $product->setPrice(mt_rand(15, 1000));
            $product->setDescription(self::DESCRIPTION);
            $product->setCategory($this->getReference('3'));
            $manager->persist($product);
        }

        //category 4
        for ($i = 32; $i <= 40; $i++) {
            $product = new Product();
            $category = new Category();
            $product->setName("Product $i");
            $product->setPrice(mt_rand(20, 250));
            $product->setDescription(self::DESCRIPTION);
            $product->setCategory($this->getReference('4'));
            $manager->persist($product);
        }
        //category 4
        for ($i = 40; $i <= 45; $i++) {
            $product = new Product();
            $category = new Category();
            $product->setName("Product $i");
            $product->setPrice(mt_rand(150, 450));
            $product->setDescription(self::DESCRIPTION);
            $product->setCategory($this->getReference('5'));
            $manager->persist($product);
        }
        $manager->flush();
    }

    /**
     * Get the order of this fixture
     * @return array
     */

    public function getDependencies() {
        return array(
            LoadCategory::class,
        );
    }
}