<?php

namespace App\Tests\Entity;

use App\Entity\Task;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TaskTest extends KernelTestCase
{
    private $task;
    
    public function setUp(): void
    {
        $this->task = new Task();
    }
    
    public function testToggle()
    {
        $this->assertSame(false, $this->task->isDone());
    }

    public function testCreatedAt()
    {
        $date = new \DateTime();
        $this->task->setCreatedAt($date);
        $this->assertSame($date, $this->task->getCreatedAt());
    }
}
