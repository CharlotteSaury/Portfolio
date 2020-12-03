<?php

namespace App\Tests\Controller;

use App\Tests\Utils\NeedLogin;
use App\DataFixtures\UserFixtures;
use App\DataFixtures\TechnoFixtures;
use App\DataFixtures\RealizationFixtures;
use Symfony\Component\HttpFoundation\Response;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    use NeedLogin;
    use FixturesTrait;

    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient();
        $this->loadFixtures([RealizationFixtures::class, TechnoFixtures::class, UserFixtures::class]);
    }

    /**
     * Test login page not authenticated user.
     *
     * @return void
     */
    public function testLoginPage()
    {
        $crawler = $this->client->request('GET', '/login');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorExists('form');
        $this->assertCount(3, $crawler->filter('input'));
        $this->assertSame(1, $crawler->filter('button:contains("Se connecter")')->count());
    }

    /**
     * Test login with valid credentials.
     *
     * @return void
     */
    public function testLoginValidCredentials()
    {
        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->selectButton('Se connecter')->form();
        $form['email'] = 'admin@email.fr';
        $form['password'] = 'password';
        $this->client->submit($form);

        $crawler = $this->client->followRedirect();
        $this->assertSame(1, $crawler->filter('html:contains("Dashboard")')->count());
    }

    /**
     * Test login with invalid credentials.
     *
     * @return void
     */
    public function testLoginInvalidCredentials()
    {
        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->selectButton('Se connecter')->form();
        $form['email'] = 'invalidemail';
        $form['password'] = 'invalidpass';
        $this->client->submit($form);

        $this->assertResponseStatusCodeSame(302);
        $crawler = $this->client->followRedirect();
        $this->assertSelectorExists('.alert.alert-error', 'Invalid credentials.');
        $this->assertSame(1, $crawler->filter('button:contains("Se connecter")')->count());
    }

    public function testLogout()
    {
        $this->login($this->client, $this->getUser('admin@email.fr'));
        $this->client->request('GET', '/logout');
        $this->assertResponseRedirects('http://localhost/');
    }
}