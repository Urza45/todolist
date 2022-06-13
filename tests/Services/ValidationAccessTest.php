<?php

namespace App\Tests\Services;

use App\Entity\Task;
use App\Entity\User;
use App\Services\ValidationAccess;
use PHPUnit\Framework\TestCase;

class ValidationAccessTest extends TestCase
{
    private $task;
    private $user;
    private $validator;

    public function setUp(): void
    {
        $this->task = new Task();
        $this->user = new User();
        $this->validator = new ValidationAccess();
    }

    public function testDeleteGrantedAdmin(): void
    {
        $this->user->setRoles(['ROLE_ADMIN']);

        $this->assertSame(true, $this->validator->deleteGranted($this->task, $this->user));
    }

    public function testDeleteGrantedNotAdmin(): void
    {
        $this->user->setRoles(['ROLE_USER']);
        $this->user->addTask($this->task);

        $this->assertSame(true, $this->validator->deleteGranted($this->task, $this->user));
    }

    public function testDeleteNotGranted(): void
    {
        $this->user->setRoles(['ROLE_USER']);

        $this->assertSame(false, $this->validator->deleteGranted($this->task, $this->user));
    }
}
