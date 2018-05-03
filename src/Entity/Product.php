<?php
/**
 * Created by PhpStorm.
 * User: armel
 * Date: 16/11/17
 * Time: 14:55
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 * @ORM\Table(name="product")
 */
class Product {
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
     * @Assert\NotBlank()
     * @Assert\Range(
     *      min = 1,
     *      max = 2000
     * )
     * @ORM\Column(type="decimal", scale=2)
     */
    private $price;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 8,
     *      max = 850,
     *		minMessage = "Your first name must be at least {{ limit }} characters long",
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters"
     * )
     * @ORM\Column(type="text")
     */
    public $description;

    /**
     * @var Category
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="products", cascade="persist")
     */
    private $category;

    /**
     * @return string
     */
    public function getName() : ?string {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName( string  $name) {
        $this->name = $name;
    }

    /**
     * @return float
     */
    public function getPrice():?float {
        return $this->price;
    }

    /**
     * @param mixed $description
     * @return Product
     */
    public function setDescription(string $description ):Product {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string {
        return $this->description;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price) {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getId():?int {
        return $this->id;
    }

    /**
     * @return Category
     */
    public function getCategory(): ?Category {
        return $this->category;
    }

    /**
     * @param Category $category
     */
    public function setCategory(Category $category) {
        $this->category = $category;
    }

}