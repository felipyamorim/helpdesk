<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class IndicadorControllerTest extends WebTestCase
{
    public function testResolvidoaberto()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/resolvidoAberto');
    }

    public function testBalancoanual()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/balancoAnual');
    }

}
