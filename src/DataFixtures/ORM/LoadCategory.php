<?php
/**
 *  * Created by PhpStorm.
 * User: armel ( @armel.m )
 * Date: 20/11/17
 * Time: 15:41
 */

namespace App\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

use App\Entity\Category;

class LoadCategory extends Fixture {

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager) {

        $categories = [
            "High tech", "Butchery", "Thanksgiving", "Crafts", "Bakery", "Fresh food"
        ];
        foreach ($categories as $key => $value) {
            $category = new Category();
            $category->setName($value);
            $this->addReference("$key", $category);

            $manager->persist($category);
        }


        $manager->flush();
    }

}