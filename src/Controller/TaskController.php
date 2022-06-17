<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
// use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TaskController extends AbstractController
{

    /**
     * listAction
     * 
     * @Route("/tasks", name="task_list")
     *
     * @param  TaskRepository $repoTask
     * @return void
     */
    public function listAction(TaskRepository $repoTask)
    {
        return $this->render(
            'task/list.html.twig',
            [
                'tasks' => $repoTask->findAll(),
                'titre' => 'Liste des tâches'
            ]
        );
    }

    /**
     * listToDoAction
     * 
     * @Route("/tasks/todo", name="task_list_todo")
     *
     * @param  TaskRepository $repoTask
     * @return void
     */
    public function listToDoAction(TaskRepository $repoTask)
    {
        return $this->render(
            'task/list.html.twig',
            [
                'tasks' => $repoTask->findBy(['isDone' => 0]),
                'titre' => 'Liste des tâches à terminer'
            ]
        );
    }

    /**
     * listDoneAction
     * 
     * @Route("/tasks/done", name="task_list_done")
     *
     * @param  TaskRepository $repoTask
     * @return void
     */
    public function listDoneAction(TaskRepository $repoTask)
    {
        return $this->render(
            'task/list.html.twig',
            [
                'tasks' => $repoTask->findBy(['isDone' => 1]),
                'titre' => 'Liste des tâches faites'
            ]
        );
    }

    /**
     * createAction
     * 
     * @Route("/tasks/create", name="task_create")
     *
     * @param  Request $request
     * @param  ManagerRegistry $doctrine
     * @return void
     */
    public function createAction(Request $request, ManagerRegistry $doctrine)
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $doctrine->getManager();
            // Add connected User as creator
            $task->setUser($this->getUser());
            $manager->persist($task);
            $manager->flush();

            $this->addFlash('success', 'La tâche a été bien été ajoutée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * editAction
     * 
     * @Route("/tasks/{id}/edit", name="task_edit")
     *
     * @param  Task $task
     * @param  Request $request
     * @param  ManagerRegistry $doctrine
     * @return void
     */
    public function editAction(Task $task, Request $request, ManagerRegistry $doctrine)
    {
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $doctrine->getManager()->flush();

            $this->addFlash('success', 'La tâche a bien été modifiée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);
    }

    /**
     * toggleTaskAction
     * 
     * @Route("/tasks/{id}/toggle", name="task_toggle")
     *
     * @param  Task $task
     * @param  ManagerRegistry $doctrine
     * @return void
     */
    public function toggleTaskAction(Task $task, ManagerRegistry $doctrine)
    {
        $task->toggle(!$task->isDone());
        $doctrine->getManager()->flush();

        $statusTask = 'non terminée';
        if ($task->isDone()) {
            $statusTask = 'faite';
        }

        $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme %s.', $task->getTitle(), $statusTask));

        return $this->redirectToRoute('task_list');
    }

    /**
     * deleteTaskAction
     * 
     * @Route("/tasks/{id}/delete", name="task_delete")
     *
     * @param  Task $task
     * @param  ManagerRegistry $doctrine
     * @return void
     */
    public function deleteTaskAction(Task $task, ManagerRegistry $doctrine)
    {
        $manager = $doctrine->getManager();

        if ($this->isGranted('task_delete', $task)) {
            $manager->remove($task);
            $manager->flush();
            $this->addFlash('success', 'La tâche a bien été supprimée.');
            return $this->redirectToRoute('task_list');
        }
        $this->addFlash('error', 'Vous ne pouvez pas supprimer cette tache.');
        return $this->redirectToRoute('task_list');
    }
}
