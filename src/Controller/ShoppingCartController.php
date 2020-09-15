<?php

namespace App\Controller;

use App\Entity\Product;
use App\Service\ShoppingCartService;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShoppingCartController extends AbstractController
{
    /**
     * Render shopping cart view.
     *
     * @Route("/shopping/cart", name="shopping_cart")
     * @param ShoppingCartService $cart_service
     * @return Response
     */
    public function index() : Response
    {
        return $this->render('shopping_cart/index.html.twig', []);
    }

    /**
     * Return shopping cart items as JSON.
     *
     * @Rest\Get("/api/shopping/cart/find", name="shopping_cart_find")
     *
     * @param Request $request
     * @param ShoppingCartService $cart_service
     */

    public function returnShoppingCartAsJSON(ShoppingCartService $cart_service) : JsonResponse {
        $in_cart = Array();
        $in_cart = $cart_service->getShoppingCart();
        if ($in_cart) {
            $repository = $this->getDoctrine()->getRepository(Product::class);
            $products = array();
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
            return new JsonResponse($products);
        }
        else {
            return new JsonResponse(false);
        }
    }


    /**
     * Add product to shopping cart
     *
     * @Rest\Put("/api/shopping/cart/alter", name="add_to_cart")
     *
     * @param Request $request
     * @param ShoppingCartService $cart_service
     */

    public function alterCart(Request $request, ShoppingCartService $cart_service) : JsonResponse {
        $product_id = $request->request->get('id');
        $amount = $request->request->get('amount');
        if(!isset($amount)) {
            throw new \LogicException("The amount of items to add/remove was not provided to the API. Contact site administrator.");
        }
        if ($amount > 0) {
            for ($i = 0; $i < $amount; $i++) {
                // $repository = $this->getDoctrine()->getRepository(Product::class);
                $cart_service->addToShoppingCart($product_id);
            }
            return new JsonResponse("Altered shopping cart.");
        }
        else {
            for ($i = 0; $i > $amount; $i--) {
                // $repository = $this->getDoctrine()->getRepository(Product::class);
                $cart_service->removeFromShoppingCart($product_id);
            }
            return new JsonResponse("Altered shopping cart.");
        }
    }

    /**
     * Remove item from shopping cart
     *
     * @Rest\Put("/api/shopping/cart/remove", name="remove_from_cart")
     * @param Request $request
     * @param ShoppingCartService $cart_service
     * @return Response
     */

    public function removeFromCart(Request $request, ShoppingCartService $cart_service) : JsonResponse {
        $product_id = $request->request->get('id');
        $cart_service->removeProductFromShoppingCart($product_id);
        return new JsonResponse("Removed product from shopping cart");
    }

    /**
     * Empty shopping cart
     *
     * @Rest\Delete("/api/shopping/cart/empty", name="empty_shopping_cart")
     * @param ShoppingCartService $cart_service
     * @return Response
     */

    public function emptyCart(ShoppingCartService $cart_service) : JsonResponse {
        $cart_service->emptyShoppingCart();
        return new JsonResponse("Emptied shopping cart.");
    }

}
