<?php

namespace App\Tests\Controller;

use App\DataFixtures\AppFixtures;
use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HTTPFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends ConnectedUserWebTestCase
{
    public function testListAction()
    {
        $urlGenerator = $this->client->getContainer()->get('router.default');

        $this->client->request(
            Request::METHOD_GET,
            $urlGenerator->generate('user_list')
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testCreateAction()
    {
        $urlGenerator = $this->client->getContainer()->get('router.default');
        $crawler = $this->client->request(
            Request::METHOD_POST,
            $urlGenerator->generate('user_create')
        );

        $form = $crawler->selectButton('Ajouter')->form(
            [
                'user[username]' => 'Utilisateur ' . random_int(1, 100),
                'user[password][first]' => '123456',
                'user[password][second]' => '123456',
                'user[email]' => 'mon@email.fr',
                'user[roles]' => 'ROLE_USER',
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
            $urlGenerator->generate('user_edit', ["id" => 1])
        );

        $form = $crawler->selectButton('Modifier')->form(
            [
                'user[password][first]' => '123456',
                'user[password][second]' => '123456',
                'user[email]' => 'mon@email.fr',
                'user[roles]' => 'ROLE_USER',
            ]
        );
        $this->client->submit($form);
        $this->assertResponseRedirects();
        $this->client->followRedirect();
        $this->assertSelectorNotExists('.alert.alert-danger');

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
    }
}
