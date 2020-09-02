<?php

namespace Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Task;
use App\Entity\User;
use Symfony\Component\DomCrawler\Crawler;
use App\Tests\Controller\SecurityControllerTest;

class TaskControllerTest extends WebTestCase
{
    public function getTestUser() {
      $username = 'TestUser';
      $password = 'password';
      $email = 'contact@mailtest.com';
      $roles = ['ROLE_USER'];

      $user = new User($username, $password, $email, $roles);
      $user->setUsername($username);
      $user->setPassword($password);
      $user->setEmail($email);
      $user->setRoles($roles);

      return $user;
    }

    public function testTestAreWorking()
    {
        $this->assertEquals(2, 1 + 1);
    }

    public function testCreateTask()
    {
      $username = 'TestUser';
      $password = 'password';
      $email = 'contact@mailtest.com';
      $roles = ['ROLE_USER'];

      $user = new User($username, $password, $email, $roles);
      $user->setUsername($username);
      $user->setPassword($password);
      $user->setEmail($email);
      $user->setRoles($roles);

        $title = 'Ma tâche';
        $content = 'Ma description de tâche';

        $task = new Task($title, $content);
        $task->setCreatedAt(new \DateTime());
        $task->setTitle($title);
        $task->setContent($content);
        $task->setCreatedBy($user);

        return $task;
    }

    public function assertHasErrors(Task $task, int $number = 0) {
        self::bootKernel();
        $error = self::$container->get('validator')->validate($task);
        $this->assertCount($number, $error);
    }

    public function testValidEntity() {
        $this->assertHasErrors($this->testCreateTask(), 0);
    }

    //-------------- ACTIONS
    public function testListAction()
    {
        $securityControllerTest = new SecurityControllerTest();
        $client = $securityControllerTest->testLogin();

        $crawler = $client->request('GET', '/tasks');
        static::assertSame(200, $client->getResponse()->getStatusCode());
    }

    //------------PAGES STATUS AND CONTENT ---------------
    public function testHomePageIsUp() {
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }

    public function testTaskListPage() {
        $client = static::createClient();
        $client->request('GET', '/tasks');
        $this->assertSame(302, $client->getResponse()->getStatusCode());
    }

    public function testTaskListContent() {
        $client = static::createClient();
        $client->request('GET', '/tasks');
        $this->assertSame(302, $client->getResponse()->getStatusCode());
    }

    public function testTaskCreationPage() {
        $client = static::createClient();
        $client->request('GET', 'tasks/create');

        $this->assertSame(302, $client->getResponse()->getStatusCode());
    }

    public function testTaskEditionPage() {
        $client = static::createClient();
        $client->request('GET', '/tasks/{id}/edit');

        $this->assertSame(302, $client->getResponse()->getStatusCode());
    }

    public function testTaskDoneAction() {
        $client = static::createClient();
        $client->request('GET', '/tasks/{id}/toggle');

        $this->assertSame(302, $client->getResponse()->getStatusCode());
    }

    public function testTaskDeletingAction() {
        $client = static::createClient();
        $client->request('GET', '/tasks/{id}/delete');

        $this->assertSame(302, $client->getResponse()->getStatusCode());
    }

}
