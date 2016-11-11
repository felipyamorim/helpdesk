<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        // Acessar a rota /
        $client->request('GET', '/');

        // Verificar o status 302 do redirecionamento
        $this->assertEquals(302, $client->getResponse()->getStatusCode());

        // Acessar a rota novamente
        $client->followRedirects();
        $crawler = $client->request('GET', '/');

        // Verificar se foi pra página de login
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Informe seus dados para iniciar a sessão', $crawler->filter('.login-box-msg')->text());
    }
}