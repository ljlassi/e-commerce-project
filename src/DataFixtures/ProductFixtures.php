<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $product = new Product();
        $product->setName("Test product 1");
        $product->setPrice(10);
        $product->setDescription("This is a description.");
        $product->setFeatured(true);
        $manager->persist($product);

        $product = new Product();
        $product->setName("Test product 2");
        $product->setPrice(999);
        $product->setDescription("This is the 2nd description.");
        $product->setFeatured(true);
        $manager->persist($product);

        $product = new Product();
        $product->setName("Test product 3");
        $product->setPrice(9999);
        $product->setDescription("This is the 3rd description.");
        $product->setFeatured(false);
        $manager->persist($product);
        $manager->flush();
    }
}
