<?php


namespace App\Entity;

/**
 * NOT IN USE CURRENTLY. Saved for possible future use, for now...
 *
 * Class ShoppingCartItem
 * @package App\Entity
 */

class ShoppingCartItem
{

    private $product_id;
    private $product_name;

    public function getProductId() : int {
        return $this->product_id;
    }

    public function setProductId(int $id) : void {
        $this->product_id = $id;
    }

    public function getProductName() : string {
        return $this->product_name;
    }

    public function setProductName(string $product_name) : void {
        $this->product_name = $product_name;
    }

}