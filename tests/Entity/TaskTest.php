<?php

namespace App\Tests\Entity;

use App\Entity\Task;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TaskTest extends KernelTestCase
{
    public function testToggle()
    {
        $task = new Task();
        $this->assertSame(false, $task->isDone());
    }

    public function testTitle()
    {
        # code...
    }

    public function testValidTask()
    {
        // $code = new Task();
        // $code->setTitle('Titre de la tâche')
        //     ->setContent('Le contenu')
        //     ->setIsDone(false);
        // self::bootKernel();
        // $error = self::getContainer('validator')->($code);
        // $this->assertCount(0, $error);
    }
}
