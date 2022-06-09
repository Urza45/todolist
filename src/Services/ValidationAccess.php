<?php

namespace App\Services;

use App\Entity\Task;
use App\Entity\User;

class ValidationAccess
{
    /**
     * deleteGranted
     *
     * @param  Task $task
     * @param  User $user
     * @return void
     */
    public function deleteGranted(Task $task, User $user)
    {
        if (
            (($task->getUser() === null) && in_array("ROLE_ADMIN", $user->getRoles()))
            or
            (($task->getUser() == $user))
        ) {
            return true;
        }
        return false;
    }
}
