<?php
/**
 * User: armel ( @armel.m )
 * Date: 23/01/18
 * Time: 12:10
 */

namespace App\Tests\Controller;


use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use function var_dump;

/**
 * Functional test that implements a "smoke test" of all the public and secure
 * URLs of the application.
 * See https://symfony.com/doc/current/best_practices/tests.html#functional-tests.
 *
 * Execute the application tests using this command (requires PHPUnit to be installed):
 *
 *     $ cd your-symfony-project/
 *     $ ./vendor/bin/phpunit
 */
class DefaultControllerTest extends WebTestCase {


    /** get one product
     * @return mixed
     */
    public function findOneProduct(){
        $client = static::createClient();
        $em = $client->getContainer()->get('doctrine')->getRepository(Product::class);
        $query = $em->createQueryBuilder('p')
            ->join('p.category','c')
            ->addSelect('c.name as cat, p.name,p.id,p.price,p.description')
            ->getQuery()
            ->setMaxResults(1);
        return $query->getSingleResult()[0];
    }
    /**
     * numbers of products
     * @return int
     */
    public function countProducts(): int {
        $client = static::createClient();
        $em = $client->getContainer()->get('doctrine')->getRepository(Product::class);
        $query = $em->createQueryBuilder('p')
            ->join('p.category','c')
            ->getQuery();
        $count = $query->getResult();
        return count($count);
    }
    /**
     * PHPUnit's data providers allow to execute the same tests repeated times
     * using a different set of data each time.
     * See https://symfony.com/doc/current/cookbook/form/unit_testing.html#testing-against-different-sets-of-data.
     *
     * @dataProvider getPublicUrls
     */
    public function testPublicUrls($url)  {
        $client = static::createClient();
        $crawler = $client->request('GET', $url);
        $this->assertSame(
            Response::HTTP_OK,
            $client->getResponse()->getStatusCode(),
            sprintf('The %s public URL loads correctly.', $url)
        );
    }
    /**
     * A good practice for tests is to not use the service container, to make
     * them more robust. However, in this example we must access to the container
     * to get the entity manager and make a database query. The reason is that
     * blog post fixtures are randomly generated and there's no guarantee that
     * a given blog post slug will be available.
     */
    public function testPublicProduct()
    {
        $client = static::createClient();
        // the service container is always available via the test client
        $product = $client->getContainer()->get('doctrine')->getRepository(Product::class)->findAll();
        $client->request('GET', sprintf('/product/show/%d', $product[0]->getId() ));
        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }
    public function testHomePageContainsProduct()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertTrue($crawler->filter('.product')->count() == 10);
    }
    public function testHomePageContainsLinks()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $link = $crawler
            ->filter('.product a ') // find all links with the text "Greet"
            ->eq(1) // select the second link in the list
            ->link()
        ;
        $crawler = $client->click($link);
        // var_dump($this->findOneProduct()->getId());
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
    public function testAddProductForm() {
        $client = static::createClient();
        $crawler = $client->request('GET', '/product/new');
        $buttonCrawlerNode = $crawler->filter('form');
        $form = $buttonCrawlerNode->form([
            'product[price]'    => 78,
            'product[category]'    =>"6",
            'product[name]'    =>" B.A mon super produit",
            'product[description]'    =>"B.A ma super description du produit",
        ]);
        $values = $form->getPhpValues();
        // Submit the form .
        $crawler = $client->request($form->getMethod(), $form->getUri(), $values, $form->getPhpFiles());
        $this->assertEquals(49, $this->countProducts());
    }
    public function getPublicUrls()
    {
        yield ['/'];
        yield ['/product/new'];
        yield ['/contact'];

    }

}