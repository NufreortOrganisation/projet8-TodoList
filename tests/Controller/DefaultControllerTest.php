<?php


namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HTTPFoundation\Response;

class DefaultControllerTest extends WebTestCase
{

    private $client = null;

    public function setUp(): void
    {
        $this->client = static::createClient();
        $this->login = new UserControllerTest();
    }

    public function loginUser(): void
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form(array(
          '_username' => 'Admin',
          '_password' => 'admin'
        ));
        $crawler = $client->submit($form);
    }

    public function testHomepageIsUp()
  {
    $this->client->request('GET', '/');

    static::assertEquals(
      Response::HTTP_OK,
      $this->client->getResponse()->getStatusCode()
    );
  }

}
