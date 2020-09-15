<?php


namespace App\Service;


use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Service for handling the session side of the shopping cart.
 *
 * Class ShoppingCartService
 * @package App\Service
 */

class ShoppingCartService
{

    private $session;

    /**
     * ShoppingCartService constructor.
     * @param SessionInterface $session
     */

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * add item to shopping cart. Shopping cart items are stored as an array in session.
     *
     * @param int $product_id
     */

    public function addToShoppingCart(int $product_id) : void {
        $session_products = $this->session->get('shopping_cart_items');
        if($session_products) {
            array_push($session_products, $product_id);
        }
        else {
            $session_products = [$product_id];
        }
        $this->session->set('shopping_cart_items', $session_products);
    }

    /**
     * Remove item from shopping cart.
     *
     * @param int $product_id
     */

    public function removeFromShoppingCart(int $product_id) : void {
        $session_products = $this->session->get('shopping_cart_items');
        $i = array_search($product_id, $session_products);
        unset($session_products[$i]);
        $session_products = array_values($session_products);
        $this->session->set('shopping_cart_items', $session_products);
    }

    /**
     * Get shopping cart from session, return it.
     *
     * @return mixed
     */

    public function getShoppingCart() {
        return $this->session->get("shopping_cart_items");
    }

    /**
     * Remove all instances of a single product from shopping cart.
     *
     * @param int $product_id
     */

    public function removeProductFromShoppingCart(int $product_id) : void {
        $session_products = $this->session->get('shopping_cart_items');
        foreach ($session_products as $key => $value) {
            if ($session_products[$key] == $product_id) {
                unset($session_products[$key]);
            }
        }
        $session_products = array_values($session_products);
        $this->session->set('shopping_cart_items', $session_products);
    }

    /**
     * Empty shopping cart by removing it's data from session.
     */

    public function emptyShoppingCart() : void {
        $this->session->remove('shopping_cart_items');
    }

}