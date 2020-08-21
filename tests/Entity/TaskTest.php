<?php

namespace Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Entity\Task;
use App\Entity\User;

class TaskTest extends KernelTestCase
{
    public function testTestAreWorking()
    {
        $this->assertEquals(2, 1 + 1);
    }

    public function getNewTask(): Task
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

    public function assertHasErrors(Task $task, int $number = 0)
    {
        self::bootKernel();
        $errors = self::$container->get('validator')->validate($task);
      //  $messages = [];
      //  foreach($errors as $error)
      //  {
      //      $messages[] = $error->getPropertyPath() . ' => ' .
      //      $error->getMessage();
      //  }
        $this->assertCount($number, $errors);
    }

    public function testGetNewTask()
    {
        $this->assertHasErrors($this->getNewTask(), 0);
    }

    public function testinvalidBlankTaskTitle()
    {
      //dd($this->getNewTask());
        $this->assertHasErrors($this->getNewTask()->setTitle(''), 1);
    }

    public function testinvalidBlankTaskContent()
    {
        $this->assertHasErrors($this->getNewTask()->setContent(''), 1);
    }

    public function testEntity(Task $task)
    {
        $taskToTest = $this->getNewTask();
        $this->assertIsA($task, $taskToTest);
    }
}
