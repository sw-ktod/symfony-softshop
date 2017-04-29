<?php

namespace ShopBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CartControllerTest extends WebTestCase
{
    public function testGet()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/cart');
    }

    public function testAdd()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/cart');
    }

    public function testRemove()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/cart');
    }

    public function testReset()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/reset');
    }

    public function testCheckout()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/cart/checkout');
    }

}
