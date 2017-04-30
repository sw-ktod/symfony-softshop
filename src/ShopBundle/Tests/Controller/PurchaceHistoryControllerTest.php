<?php

namespace ShopBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PurchaceHistoryControllerTest extends WebTestCase
{
    public function testGet()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'purchaceHistory');
    }

    public function testList()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'purchaceHistory');
    }

}
