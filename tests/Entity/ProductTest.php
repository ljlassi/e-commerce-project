<?php


namespace App\Tests\Entity;


use App\Entity\Product;
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for product entity.
 *
 * Class ProductTest
 * @package App\Tests\Entity
 */

class ProductTest extends TestCase
{

    public function testSetName() : void {
        $product = new Product();
        $test_name = "Testproduct";
        $product->setName($test_name);
        $this->assertEquals($test_name, $product->getName());
    }

    public function testSetPrice() : void {
        $product = new Product();
        $test_price = 1000;
        $product->setPrice($test_price);
        $this->assertEquals($test_price, $product->getPrice());
    }

    public function testSetFeatured() : void {
        $product = new Product();
        $test_value = true;
        $product->setFeatured($test_value);
        $this->assertEquals($test_value, $product->getFeatured());
    }

    public function testSetImageFileName() : void {
        $product = new Product();
        $test_url = "/images/file.jpg";
        $product->setImageFileName($test_url);
        $this->assertEquals($test_url, $product->getImageFileName());
    }

}