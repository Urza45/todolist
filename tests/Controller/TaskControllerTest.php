<?php

namespace App\Tests\Controller;

use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use App\Services\ValidationAccess;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HTTPFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{
    private $client = null;

    public function setUp(): void
    {
        $this->client = static::createClient();
    }

    private function getTestUser()
    {
        $userRepository = static::getContainer()->get(UserRepository::class);
        // retrieve the test user
        $testUser = $userRepository->findOneByUsername('admin');
        // simulate $testUser being logged in
        $this->client->loginUser($testUser);
    }

    public function testListAction()
    {
        $this->getTestUser();
        $urlGenerator = $this->client->getContainer()->get('router.default');

        $this->client->request(
            Request::METHOD_GET,
            $urlGenerator->generate('task_list')
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testListToDoAction()
    {
        $this->getTestUser();
        $urlGenerator = $this->client->getContainer()->get('router.default');

        $this->client->request(
            Request::METHOD_GET,
            $urlGenerator->generate('task_list_todo')
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testListDoneAction()
    {
        $this->getTestUser();
        $urlGenerator = $this->client->getContainer()->get('router.default');

        $this->client->request(
            Request::METHOD_GET,
            $urlGenerator->generate('task_list_done')
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testCreateAction()
    {
        $this->getTestUser();
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
        $this->getTestUser();
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
        $this->getTestUser();
        $urlGenerator = $this->client->getContainer()->get('router.default');
        $crawler = $this->client->request(
            Request::METHOD_GET,
            $urlGenerator->generate('task_toggle', ["id" => 4])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
    }

    public function testGrantedDeleteTaskAction()
    {
        $this->getTestUser();
        $urlGenerator = $this->client->getContainer()->get('router.default');
        $crawler = $this->client->request(
            Request::METHOD_GET,
            $urlGenerator->generate('task_delete', ["id" => 10])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
    }

    public function testNotGrantedDeleteTaskAction(ValidationAccess $validator)
    {
        $user = $this->getTestUser();


        $urlGenerator = $this->client->getContainer()->get('router.default');
        $crawler = $this->client->request(
            Request::METHOD_POST,
            $urlGenerator->generate('task_delete', ["id" => 8])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
    }
}
