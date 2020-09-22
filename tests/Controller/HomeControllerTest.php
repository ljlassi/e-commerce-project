<?php


namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Response test for home controller. CURRENTLY DOES NOT WORK PROPERLY,
 * would require test database since homepage now fetched featured products from
 * database.
 *
 * Class HomeControllerTest
 * @package App\Tests\Controller
 */

class HomeControllerTest extends WebTestCase
{

    public function testHomePage() : void {
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

    }

}
