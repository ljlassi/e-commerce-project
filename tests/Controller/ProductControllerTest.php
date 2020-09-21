<?php


namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{

    public function testListAllProducts() {
        $client = static::createClient();
        $client->request('GET', '/products/list');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

}