<?php


namespace App\Controller;


use App\Entity\Product;
use App\Form\Type\ProductFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProductController extends AbstractController
{

    /**
     * @Route("/admin/product/add", name="add_product")
     *
     * @param EntityManagerInterface $entityManager
     * @return Response
     */

    public function createProduct(Environment $twig, Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger) : Response {
        $product = new Product();

        $form = $this->createForm(ProductFormType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();

            // this condition is needed because the 'image' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                // Move the file to the directory where images are stored
                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'imageFilename' property to store the PDF file name
                // instead of its contents
                $product->setImageFilename($newFilename);
            }
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
        return new Response('Made product named: ' . $product->getName() . ' - featured.');
    }

    /**
     * @Route("/admin/products/featured/unfeature", name="unfeature_product")
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @return Response
     */

    public function makeProductNotFeatured(EntityManagerInterface $entityManager, Request $request) : Response {
        $id = $request->query->get('id');
        $repository = $this->getDoctrine()->getRepository(Product::class);
        $product = $repository->find($id);
        $product->setFeatured(false);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($product);
        $entityManager->flush();
        return new Response('Removed product named: ' . $product->getName() . ' - from featured products.');
    }

}