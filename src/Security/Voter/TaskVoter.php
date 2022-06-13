<?php

namespace App\Security\Voter;

use App\Entity\Task;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class TaskVoter extends Voter
{

    public const TASK_CREATE = 'task_create';
    public const TASK_EDIT = 'task_edit';
    public const TASK_VIEW = 'task_view';
    public const TASK_DELETE = 'task_delete';

    protected function supports(string $attribute, $task): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [
            self::TASK_CREATE,
            self::TASK_EDIT,
            self::TASK_VIEW,
            self::TASK_DELETE
        ])
            && $task instanceof \App\Entity\Task;
    }

    protected function voteOnAttribute(string $attribute, $task, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // Checking if the task has an author


        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::TASK_CREATE:
                // logic to determine if the user can CREATE
                // return true or false
                return $this->canCreate($task, $user);
                break;
            case self::TASK_EDIT:
                // logic to determine if the user can EDIT
                // return true or false
                return $this->canEdit($task, $user);
                break;
            case self::TASK_VIEW:
                // logic to determine if the user can VIEW
                // return true or false
                return $this->canView($task, $user);
                break;
            case self::TASK_DELETE:
                // logic to determine if the user can DELETE
                // return true or false
                return $this->canDelete($task, $user);
                break;
        }

        return false;
    }

    private function canCreate(Task $task, User $user)
    {
        return true;
    }

    private function canEdit(Task $task, User $user)
    {
        return true;
    }

    private function canView(Task $task, User $user)
    {
        return true;
    }

    private function canDelete(Task $task, User $user)
    {
        return (
            (($task->getUser() === null) && in_array("ROLE_ADMIN", $user->getRoles()))
            or
            (($task->getUser() == $user))
        );
    }
}
