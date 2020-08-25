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

    public function assertHasErrors(Task $task, int $number = 0) {
        self::bootKernel();
        $error = self::$container->get('validator')->validate($task);
        $this->assertCount($number, $error);
    }

    public function testValidEntity() {
        $this->assertHasErrors($this->getNewTask(), 0);
    }

    public function testGetTitle() {
        $task = $this->getNewTask();
        $task->setTitle('Titre test');
        $taskTitle = $task->getTitle();

        $this->assertSame('Titre test', $task->getTitle(), 0);
    }

    public function testGetContent() {
        $task = $this->getNewTask();
        $task->setContent('Contenu test');
        $taskTitle = $task->getContent();

        $this->assertSame('Contenu test', $task->getContent(), 0);
    }

    public function testGetCreatedAt() {
        $task = $this->getNewTask();
        $task->setCreatedAt('2020-08-05');
        $taskTitle = $task->getCreatedAt();

        $this->assertSame('2020-08-05', $task->getCreatedAt(), 0);
    }

    public function testGetCreatedBy() {
        $task = $this->getNewTask();
        $taskCreator = $task->getCreatedBy();

        $this->assertInstanceOf(User::class, $taskCreator, 0);
    }

    public function testGetStartAt() {
        $task = $this->getNewTask();
        $task->setStartAt(date_create('2020-08-05 00:00:00'));
        $taskTitle = $task->getStartAt();

        $this->assertSame('2020-08-05 00:00:00', date_format($task->getStartAt(), 'Y-m-d H:i:s'), 0);
    }

    public function testGetEndAt() {
        $task = $this->getNewTask();
        $task->setEndAt(date_create('2020-08-05 00:00:00'));
        $taskTitle = $task->getEndAt();

        $this->assertSame('2020-08-05 00:00:00', date_format($task->getEndAt(), 'Y-m-d H:i:s'), 0);
    }
}
