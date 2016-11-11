<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    public function testLogin()
    {
        $client = static::createClient();
        $client->followRedirects();

        $crawler = $client->request('GET', '/login');

        $buttonCrawlerNode = $crawler->selectButton('Entrar');

        $form = $buttonCrawlerNode->form(array(
            'username'  => 'felipyamorim@gmail.com',
            'password'  => 'tatiana10',
        ));

        $crawler = $client->submit($form);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('homepage', $client->getRequest()->attributes->get('_route'));
        $this->assertRegExp('/Dash Board/i', $crawler->filter('.content-header > h1')->text());
    }

    public function testLogout()
    {
        $client = static::createClient();
        $client->followRedirects();

        $crawler = $client->request('GET', '/logout');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Informe seus dados para iniciar a sessão', $crawler->filter('.login-box-msg')->text());
    }
}
