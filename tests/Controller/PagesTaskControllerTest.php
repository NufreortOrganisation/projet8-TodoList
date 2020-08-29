<?php

namespace Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PagesTaskControllerTest extends WebTestCase
{
    public function testHomePageIsUp() {
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertSame(200, $client->getResponse()->getStatusCode());

        //Pour savoir à quoi ressemble la page renvoyer
        //echo $client->getResponse()->getStatusCode();
    }

    public function testHomePage() {
        $client = static::createClient();
        //le crawler permet de se ballader dans le DOMdocuent de notre page
        $crawler = $client->request('GET', '/');

        $this->assertSame(1, $crawler->filter('html:contains("Bienvenue sur Todo List,
         l\'application vous permettant de gérer l\'ensemble de vos tâches sans effort !")'
         )->count());
    }

    public function testMessageHomePage() {
        $client = static::createClient();
        //le crawler permet de se ballader dans le DOMdocuent de notre page
        $crawler = $client->request('GET', 'Symfony/p8-v2/public/');

        $this->assertSelectorTextContains('h1', 'Bienvenue sur Todo List,
         l\'application vous permettant de gérer l\'ensemble de vos tâches sans effort !');
    }

    public function testTaskCreation() {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $link = $crawler->selectLink('Créer une nouvelle tâche')->link();
        $crawler = $client->click($link); // simule le click d'un utilisateur

        $form = $crawler->selectButton('submit')->form(); //permet de simuler le remplissage du formulaire
        $form['task_title'] = 'Title'; //les valeurs importent peu
        $form['task_content'] = 'Content';
        $form['task_startAt'] = date("d/m/Y");
        $form['task_endAt'] = date("d/m/Y");
        $crawler = $client->submit($form);// teste lla validation du formulaire

        $crawler = $client->followRedirect();
        //echo $client->getResponse()->getContent();
        //$this->assertSame(1, $crawler->filter('html:contains("Bienvenue sur Todo List, l\'application vous permettant de gérer l\'ensemble de vos tâches sans effort !")')->count());
        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
    }


}
