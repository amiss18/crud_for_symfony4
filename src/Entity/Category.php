<?php
/**
 *  * Created by PhpStorm.
 * User: armel ( @armel.m )
 * Date: 20/11/17
 * Time: 14:58
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 * @ORM\Table(name="category")
 */
class Category {

  /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 2,
     *      max = 90
     * )
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @var Product
     * @ORM\OneToMany(targetEntity="Product", mappedBy="category", cascade={"persist", "remove"})
     */
    private $products;

    public function __construct() {
       $this->products = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): ?string {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name) {
        $this->name = $name;
    }


    /**
     * Add product
     *
     * @param Product $product
     * @return Category
     * @internal param $ \
     *
     */
    public function addProduct( Product $product ):?Category {
        $this->products[] = $product;

        return $this;
    }

    /**
     * Remove product
     *
     * @param Product
     */
    public function removeProduct( Product $product ) {
        $this->products->removeElement($product);
    }

    public function __toString():string {
      return $this->name;
    }


}