<?php

namespace Tests\Entity;

use App\Entity\User;
use App\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends KernelTestCase
{
    public function testTestAreWorking()
    {
        $this->assertEquals(2, 1 + 1);
    }

    public function getNewUser(): User
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

        return $user;
    }

    public function assertHasErrors(User $user, int $number = 0) {
        self::bootKernel();
        $error = self::$container->get('validator')->validate($user);
        $this->assertCount($number, $error);
    }

    public function testValidEntity() {
        $this->assertHasErrors($this->getNewUser(), 0);
    }

    public function testGetUsername() {
        $user = $this->getNewUser();
        $user->setUsername('TesteurPro');

        $this->assertSame('TesteurPro', $user->getUsername(), 0);
    }

    public function testGetPassword() {
        $user = $this->getNewUser();
        $user->setPassword('PasswordTest');

        $this->assertSame('PasswordTest', $user->getPassword(), 0);
    }

    public function testGetEmail() {
        $user = $this->getNewUser();
        $user->setEmail('test@test.com');

        $this->assertSame('test@test.com', $user->getEmail(), 0);
    }

    public function testGetRoles() {
        $user = $this->getNewUser();
        $user->setRoles(['ROLE_TEST']);

        $this->assertContains('ROLE_TEST', $user->getRoles(), 0);
    }

  //  public function testGetTask() {
  //      $user = $this->getNewUser();

  //      $title = 'Ma tâche';
  //      $content = 'Ma description de tâche';

  //      $task = new Task($title, $content);
  //      $task->setCreatedAt(new \DateTime());
  //      $task->setTitle($title);
  //      $task->setContent($content);
  //      $task->setCreatedBy($user);

  //      $user->addTask($task);

  //      $this->assertInstanceOf(ArrayCollection::class, $user->getTasks(), 0);
  //  }

}
