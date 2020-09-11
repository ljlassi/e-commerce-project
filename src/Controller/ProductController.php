<?php


namespace App\Controller;


use App\Entity\Product;
use App\Form\Type\EditProductFormType;
use App\Form\Type\ProductFormType;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * Controller for product related actions.
 *
 * Class ProductController
 * @package App\Controller
 */

class ProductController extends AbstractController
{

    /**
     * Find featured products.
     *
     * @Rest\Get("/api/products/find/featured", name="find_featured_products")
     */

    public function findFeaturedProducts() : JsonResponse {
        $products = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findFeatured();
        // if you know the data to send when creating the response
        return new JsonResponse($products);
    }

    /**
     * Find featured products.
     *
     * @Rest\Get("/api/products/find/all", name="find_all_products")
     */

    public function findAllProducts() : JsonResponse {
        $products = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findAll();
        // if you know the data to send when creating the response
        return new JsonResponse($products);
    }

    /**
     * For creating a product. Render product form if product is not submitted,
     * otherwise process the form and update database.
     *
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
            // so the image file must be processed only when a file is uploaded
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
                    echo $e->getMessage();
                }

                // updates the 'imageFilename' property to store the image file name
                // instead of its contents
                $product->setImageFilename($newFilename);
            }
            $product = $form->getData();

            $entityManager->persist($product);
            $entityManager->flush();

            // get product name for success message - before we re-initiate the product object
            $message = 'Saved new product named: ' . $product->getName();
            // re-render the form, to enable adding further products. Sends success message to template too.
            $product = new Product();
            $form = $this->createForm(ProductFormType::class, $product);
            $form = $form->createView();

            return new Response($twig->render('admin/add_product.html.twig', ['form' => $form, 'message' => $message]));

        }
        else {
            $form = $form->createView();

            return new Response($twig->render('admin/add_product.html.twig', ['form' => $form]));
        }
    }

    /**
     * @Route("/api/admin/products/edit", name="edit_product")
     *
     * Edit a product. Render form if form is not submitted, otherwise process form and update product information.
     *
     * @param Environment $twig
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param SluggerInterface $slugger
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */

    public function editProduct(Environment $twig, Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger) : Response {
        $product = new Product();
        $product_id = $request->query->get("id");
        $repository = $this->getDoctrine()->getRepository(Product::class);
        $product = $repository->find($product_id);
        $form = $this->createForm(EditProductFormType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();
            // this condition is needed because the 'image' field is not required
            // so the image file must be processed only when a file is uploaded
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
                    echo $e->getMessage();
                }

                // updates the 'imageFilename' property to store the image file name
                // instead of its contents
                $product->setImageFilename($newFilename);
            }
            $product = $form->getData();

            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('edit_product_view', ['message' => 'Successfully updated a product.']);

        }
        else {
            $form = $form->createView();
            $action = $this->generateUrl('edit_product', ['id' => $product_id]);
            return new Response($twig->render('admin/edit_product_form.html.twig', ['form' => $form, 'action' => $action]));
        }
    }

    /**
     * Render the view that lists all products.
     *
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
     * Render the view that allows you to edit products.
     *
     * @Route("/admin/products/edit/view", name="edit_product_view")
     *
     * @param EntityManagerInterface $entityManager
     * @param Environment $twig
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */

    public function editProductView(EntityManagerInterface $entityManager, Environment $twig, Request $request) : Response {
        $products = $entityManager->getRepository(Product::class)->findAll();
        return new Response($twig->render("admin/edit_product.html.twig", ['products' => $products]));
    }

    /**
     * Make a product featured based on ID coming in a PUT request
     *
     * @Rest\Put("/api/admin/products/featured/action", name="make_product_featured")
     *
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @return Response
     */

    public function makeProductFeatured(EntityManagerInterface $entityManager, Request $request) : Response {
        $id = $request->request->get('id');
        $repository = $this->getDoctrine()->getRepository(Product::class);
        $product = $repository->find($id);
        $product->setFeatured(true);
        $entityManager->persist($product);
        $entityManager->flush();
        return new Response('Made product named: ' . $product->getName() . ' - featured.');
    }

    /**
     * Make a product not featured, based on the ID coming from a GET request.
     *
     * @Rest\Put("/api/admin/products/featured/unfeature", name="unfeature_product")
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @return Response
     */

    public function makeProductNotFeatured(EntityManagerInterface $entityManager, Request $request) : Response {
        $id = $request->request->get('id');
        $repository = $this->getDoctrine()->getRepository(Product::class);
        $product = $repository->find($id);
        $product->setFeatured(false);
        $entityManager->persist($product);
        $entityManager->flush();
        return new Response('Removed product named: ' . $product->getName() . ' - from featured products.');
    }

    /**
     * Remove product from database.
     *
     * @Rest\Delete("api/admin/products/remove", name="remove_product")
     *
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @return Response
     */

    public function deleteProduct(EntityManagerInterface $entityManager, Request $request) : Response {
        $id = $request->query->get('id');
        $repository = $this->getDoctrine()->getRepository(Product::class);
        $product = $repository->find($id);
        $product_name = $product->getName();
        $entityManager->remove($product);
        $entityManager->flush();
        return new Response('Deleted product with name: ' . $product_name);
    }

}
