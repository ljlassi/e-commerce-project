<?php


namespace App\Service;


use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ShoppingCartService
{

    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function addToShoppingCart(int $product_id) : void {
        $session_products = Array();
        $session_products = $this->session->get('shopping_cart_items');
        if($session_products) {
            array_push($session_products, $product_id);
        }
        else {
            $session_products = [$product_id];
        }
        $this->session->set('shopping_cart_items', $session_products);
    }

    public function removeFromShoppingCart(int $product_id) : void {
        $session_products = Array();
        $session_products = $this->session->get('shopping_cart_items');
        $i = array_search($product_id, $session_products);
        unset($session_products[$i]);
        $session_products = array_values($session_products);
        $this->session->set('shopping_cart_items', $session_products);
    }

    public function getShoppingCart() {
        $session_products = Array();
        $session_products = $this->session->get("shopping_cart_items");
        return $session_products;
    }

}