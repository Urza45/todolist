<?php

namespace App\Tests\Controller;

use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use App\Services\ValidationAccess;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HTTPFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends ConnectedUserWebTestCase
{

    public function testListAction()
    {
        $urlGenerator = $this->client->getContainer()->get('router.default');

        $this->client->request(
            Request::METHOD_GET,
            $urlGenerator->generate('task_list')
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testListToDoAction()
    {
        $urlGenerator = $this->client->getContainer()->get('router.default');

        $this->client->request(
            Request::METHOD_GET,
            $urlGenerator->generate('task_list_todo')
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testListDoneAction()
    {
        $urlGenerator = $this->client->getContainer()->get('router.default');

        $this->client->request(
            Request::METHOD_GET,
            $urlGenerator->generate('task_list_done')
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testCreateAction()
    {
        $urlGenerator = $this->client->getContainer()->get('router.default');
        $crawler = $this->client->request(
            Request::METHOD_POST,
            $urlGenerator->generate('task_create')
        );

        $form = $crawler->selectButton('Ajouter')->form(
            [
                'task[title]' => 'Un titre',
                'task[content]' => 'Un contenu'
            ]
        );
        $this->client->submit($form);
        $this->assertResponseRedirects();
        $this->client->followRedirect();
        $this->assertSelectorNotExists('.alert.alert-danger');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testEditAction()
    {
        $urlGenerator = $this->client->getContainer()->get('router.default');
        $crawler = $this->client->request(
            Request::METHOD_GET,
            $urlGenerator->generate('task_edit', ["id" => 6])
        );

        $form = $crawler->selectButton('Modifier')->form(
            [
                'task[title]' => 'Un titre',
                'task[content]' => 'Un contenu'
            ]
        );
        $this->client->submit($form);
        $this->assertResponseRedirects();
        $this->client->followRedirect();
        $this->assertSelectorNotExists('.alert.alert-danger');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testToggleTaskAction()
    {
        $urlGenerator = $this->client->getContainer()->get('router.default');
        $crawler = $this->client->request(
            Request::METHOD_GET,
            $urlGenerator->generate('task_toggle', ["id" => 4])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
    }

    public function testGrantedDeleteTaskAction()
    {
        $urlGenerator = $this->client->getContainer()->get('router.default');
        $this->client->request(
            Request::METHOD_GET,
            $urlGenerator->generate('task_delete', ["id" => 4])
        );

        $this->client->followRedirect();
        $this->assertStringContainsString('La tâche a bien été supprimée.', $this->client->getResponse()->getContent());
    }

    public function testNotGrantedDeleteTaskAction()
    {
        $urlGenerator = $this->client->getContainer()->get('router.default');
        $this->client->request(
            Request::METHOD_POST,
            $urlGenerator->generate('task_delete', ["id" => 8])
        );
        $this->client->followRedirect();
        $this->assertStringContainsString('Vous ne pouvez pas supprimer cette tache.', $this->client->getResponse()->getContent());
    }
}
