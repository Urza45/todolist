<?php

namespace App\Tests\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HTTPFoundation\Response;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    private $client = null;

    public function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function testDiplayLogin()
    {
        $urlGenerator = $this->client->getContainer()->get('router.default');
        $this->client->request(Request::METHOD_HEAD, $urlGenerator->generate('login'));
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorNotExists('.alert.alert-danger');
    }

    public function testLoginWithBadCredentials()
    {
        $urlGenerator = $this->client->getContainer()->get('router.default');
        $crawler = $this->client->request(Request::METHOD_GET, $urlGenerator->generate('login'));
        $form = $crawler->selectButton('Connexion')->form(
            [
                'username' => 'Serge',
                'password' => '112222'
            ]
        );
        $this->client->submit($form);
        $this->assertResponseRedirects();
        $this->client->followRedirect();
        $this->assertSelectorExists('.alert.alert-danger');
        // $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testLogout()
    {
        $userRepository = static::getContainer()->get(UserRepository::class);
        // retrieve the test user
        $testUser = $userRepository->findOneByUsername('admin');
        // simulate $testUser being logged in
        $this->client->loginUser($testUser);

        $this->client->request('GET', '/logout');
        $this->client->followRedirect();
        $this->assertStringContainsString('Se connecter', $this->client->getResponse()->getContent());
        // $this->assertSame(1, $this->client->getResponse()->filter('html:contains("Se connecter")')->count());


        // $this->client->followRedirect();

        // $response = $this->client->getResponse();
        // $this->assertSame(302, $response->getStatusCode());

        // $crawler = $this->client->followRedirect();
        // $this->assertSame(200, $this->client->getResponse()->getStatusCode());
        // $this->assertSame(1, $crawler->filter('html:contains("Se connecter")')->count());
    }
}
