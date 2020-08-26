<?php

namespace Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Task;
use App\Entity\User;

class TaskControllerTest extends WebTestCase
{
    public function testTestAreWorking()
    {
        $this->assertEquals(2, 1 + 1);
    }

    public function testCreateTask()
    {
        $user = $this->getMockBuilder('DB\User');
        $user->disableOriginalConstructor();
        $user->getMock();

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
}
