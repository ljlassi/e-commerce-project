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
     * Render shopping cart, if there are items in cart (stored in session), render them, otherwise tell that the cart is empty.
     *
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
            foreach ($in_cart as $key => $product_id) {
                $result_keys = array_keys($in_cart, $product_id, true);
                $item_in_cart = count($result_keys);
                $product_instances = 0;
                if (isset($products)) {
                    foreach($products as $i => $product) {
                        if ($product['id'] == $product_id) {
                         $product_instances = $product_instances + 1;
                        }
                    }
                }
                if ($item_in_cart === 1 || $product_instances === 0) {
                    $product = $repository->find($product_id);
                    $products[$key] = ["id" => $product->getId(), "name" => $product->getName(), "price" => $product->getPrice(),
                        "imageFileName" => $product->getImageFileName(), 'items_in_cart' => 1];
                    $products[$key]['items_in_cart'] = $item_in_cart;
                }
                else {
                    continue;
                }
            }
            return $this->render('shopping_cart/index.html.twig', [
                'products' => $products,
            ]);
        }

        return $this->render('shopping_cart/index.html.twig', []);
    }

    /**
     * Add produc to shopping cart
     *
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

    /**
     * Remove item from shopping cart
     *
     * @Route("/shopping/cart/remove", name="remove_from_cart")
     */

    public function removeFromCart(Request $request, ShoppingCartService $cart_service) : Response {
        $product_id = $request->query->get('id');
        $cart_service->removeFromShoppingCart($product_id);
        return new Response("Removed product from shopping cart");
    }

}
