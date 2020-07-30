<?php

namespace App\Controller;

use App\Entity\Product;
use App\Service\ShoppingCartService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShoppingCartController extends AbstractController
{
    /**
     * @Route("/shopping/cart", name="shopping_cart")
     * @param ShoppingCartService $cart_service
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function index(ShoppingCartService $cart_service, EntityManagerInterface $entityManager) : Response
    {
        $in_cart = Array();
        $in_cart = $cart_service->getShoppingCart();
        if ($in_cart) {
            $repository = $this->getDoctrine()->getRepository(Product::class);
            $products = array();
            foreach ($in_cart as $key => $product_id) {
                $product = $repository->find($product_id);
                $products[$key] = ["id" => $product->getId(), "name" => $product->getName(), "price" => $product->getPrice(), "imageFileName" => $product->getImageFileName()];
            }
            return $this->render('shopping_cart/index.html.twig', [
                'products' => $products,
            ]);
        }

        return $this->render('shopping_cart/index.html.twig', []);
    }

    /**
     * @Route("shopping/cart/add", name="add_to_cart")
     *
     * @param Request $request
     * @param ShoppingCartService $cart_service
     */

    public function addToCart(Request $request, ShoppingCartService $cart_service) : Response {
        $product_id = $request->query->get('id');
        $repository = $this->getDoctrine()->getRepository(Product::class);
        $cart_service->addToShoppingCart($product_id);
        return new Response("Added product to shopping cart");
    }
}
