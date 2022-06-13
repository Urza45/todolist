<?php

namespace App\Tests\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HTTPFoundation\Response;
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
        $form = $crawler->selectButton('Sign in')->form(
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
}
