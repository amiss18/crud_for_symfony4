<?php
/**
 * Created by PhpStorm.
 * User: armel
 * Date: 16/11/17
 * Time: 14:04
 */

namespace App\Controller;


use App\Entity\Category;
use App\Entity\Product;
use App\Events;
use App\EventSubscriber\ProductNotification;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use App\Service\ProductServ;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

//for routing annotation
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends  AbstractController {


    const LIMIT = 10;//Maximum number of items available to each page


    /**
     * @Route("/{page}", name="home", requirements={"page" = "\d+"}, defaults={"page" = 1})
     *
     * @param Request $request
     * @param int $page      page number(default:1)
     * @return Response
     */
    public function indexAction( Request $request, int $page ): Response {
        $em = $this->getDoctrine()
            ->getRepository(Product::class);
       $products = $em->findProducts( $page, self::LIMIT);
        //  nombre total de pages
        $numberOfPages = ceil(count($products) / self::LIMIT);




        return $this->render('default/index.html.twig', [
            'products' => $products,
            'numberOfPages'      => $numberOfPages, //$nbPages
            'page'         => $page,
        ]);
    }


    /**
     * Displays a form to create a new Product entity.
     * @Route("/product/new", name="product_new")
     */
    public function newAction() {

        $product = new Product();

        $form = $this->createForm(ProductType::class, $product);
        return $this->render('default/add.html.twig',[
            'entity' => $product,
            'form' => $form->createView(),
        ]);
    }


    /**
     * Creates a new Product entity
     *
     * @Route("/product/save", name="product_save")
     */
    public function addAction( Request $request ) {
        //$flashbag = $request->getSession()->start();

        $product = new Product();

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            // Everything OK, redirect to wherever you want ! :
            $this->addFlash(
                'success',
                'entity Inserted Successfully!'
            );

            return $this->redirectToRoute('product_show', array('id' => $product->getId() ));


        }

        return $this->render('default/add.html.twig',[
            'entity'    => $product,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/product/show/{id}", name="product_show")
     */
    public function showAction( Product $p, Request $request ) {
        $flashbag = $request->getSession()->start();
        $em = $this->getDoctrine()
            ->getRepository(Product::class);
        $product = $em->findProductById( $p->getId());

        return $this->render('default/show.html.twig',[
            'product'    => $product,
        ]);
    }



    /**
     * Displays a form to create a new Product entity.
     * @Route("/product/edit/{id}", name="product_edit")
     */
    public function editAction( Product $p ) {
        $product = $this->getDoctrine()
            ->getRepository(Product::class)->find($p->getId());
        if (!$product) {
            throw $this->createNotFoundException('Unable to find Product entity.');
        }
        $form = $this->createForm(ProductType::class, $product);

        return $this->render('default/edit.html.twig',[
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Displays a form to create a new Product entity.
     * @Route("/product/update/{id}", name="product_update")
     */
    public function updateAction( Product $p, Request $request ) {
        $product = $this->getDoctrine()
            ->getRepository(Product::class)->find($p->getId());
        if (!$product) {
            throw $this->createNotFoundException('Unable to find Product entity.');
        }

        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            // Everything OK, redirect to wherever you want ! :
            $this->addFlash(
                'success',
                'entity updated Successfully!'
            );

            return $this->redirectToRoute('product_show', array('id' => $product->getId() ));


        }

        return $this->render('default/edit.html.twig',[
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }


    /**
     * delete entity
     *
     * @Route("/product/delete/{id}", name="product_delete")
     * @param Product $product
     * @param ProductServ $serv
     * @return Response
     */
    public function deleteProductAction( Product $product, ProductServ $serv, EventDispatcherInterface $eventDispatcher ) {
        $id = $product->getId();
        $serv->deleteProduct($product);
         $this->addFlash(
                'success',
                "Product $id deleted Successfully!"
            );
         //notify (send email )
         $eventDispatcher->dispatch(Events::PRODUCT_DELETE);
        return $this->render('default/delete.html.twig',[
           'product' => $id,
        ]);
    }


}