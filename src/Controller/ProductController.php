<?php


namespace App\Controller;


use App\Entity\Product;
use App\Form\Type\ProductFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class ProductController extends AbstractController
{

    /**
     * @Route("/admin/product/add", name="add_product")
     *
     * @param EntityManagerInterface $entityManager
     * @return Response
     */

    public function createProduct(Environment $twig, Request $request, EntityManagerInterface $entityManager) : Response {
        $product = new Product();

        $form = $this->createForm(ProductFormType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            return new Response('Saved new product named: ' . $product->getName());

        }
        else {
            $form = $form->createView();

            return new Response($twig->render('admin/add_product.html.twig', ['form' => $form]));
        }
    }

    /**
     * @Route("/products/list", name="list_products")
     *
     * @param EntityManagerInterface $entityManager
     * @param Environment $twig
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */

    public function listAllProducts(EntityManagerInterface $entityManager, Environment $twig) : Response {
        $products = $entityManager->getRepository(Product::class)->findAll();

        return new Response($twig->render("products/list_products.html.twig", ['products' => $products]));
    }

    /**
     * @Route("/admin/products/featured", name="make_product_featured_view")
     *
     * @param EntityManagerInterface $entityManager
     * @param Environment $twig
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */

    public function makeProductFeaturedView(EntityManagerInterface $entityManager, Environment $twig) : Response {
        $products = $entityManager->getRepository(Product::class)->findAll();
        return new Response($twig->render("admin/make_product_featured.html.twig", ['products' => $products]));
    }

    /**
     * @Route("/admin/products/featured/action", name="make_product_featured")
     *
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @return Response
     */

    public function makeProductFeatured(EntityManagerInterface $entityManager, Request $request) : Response {
        $id = $request->query->get('id');
        $repository = $this->getDoctrine()->getRepository(Product::class);
        $product = $repository->find($id);
        $product->setFeatured(true);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($product);
        $entityManager->flush();
        return new Response('Made product named: ' . $product->getName() . ' - featured');
    }

}