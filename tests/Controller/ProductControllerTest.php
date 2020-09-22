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

    /**
     * This unfortunately FAILS at the moment.
     *
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */

    public function testEditProductsView() : void {
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'username',
            'PHP_AUTH_PW'   => 'pa$$word'));
        $client->request('GET', '/admin/products/edit/view');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

}
