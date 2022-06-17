<?php

namespace App\Tests\Entity;

use App\Entity\User;
use App\Entity\Task;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends KernelTestCase
{

    private $task;
    private $user;

    public function setUp(): void
    {
        $this->task = new Task();
        $this->user = new User();
    }

    public function testTask()
    {
        $this->user->addTask($this->task);
        $this->assertCount(1, $this->user->getTasks());

        $tasks = $this->user->getTasks();
        $this->assertSame($this->user->getTasks(), $tasks);

        $this->user->removeTask($this->task);
        $this->assertCount(0, $this->user->getTasks());
    }
}
