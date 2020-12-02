<?php

namespace App\Tests\Controller;

use App\Tests\Utils\NeedLogin;
use App\DataFixtures\UserFixtures;
use App\DataFixtures\TechnoFixtures;
use App\DataFixtures\RealizationFixtures;
use Symfony\Component\HttpFoundation\Response;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    use NeedLogin;
    use FixturesTrait;

    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient();
        $this->loadFixtures([TechnoFixtures::class, RealizationFixtures::class, UserFixtures::class]);
    }

    /**
     * Test access to homepage
     *
     * @return void
     */
    public function testIndex()
    {
        $crawler = $this->client->request('GET', '/');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    /**
     * Test homepage integration
     *
     * @return void
     */
    public function testIndexIntegration()
    {
        $crawler = $this->client->request('GET', '/');
        $this->assertSame(1, $crawler->filter('h1:contains("Charlotte Saury")')->count());
        $this->assertSame(1, $crawler->filter('h2:contains("Développeuse Web PHP/Symfony en recherche d\'emploi sur la région de Vannes")')->count());
        $this->assertCount(4, $crawler->filter('h3'));
        $this->assertCount(6, $crawler->filter('div.techno-card'));
        $this->assertCount(5, $crawler->filter('div.realization-card'));
        $this->assertCount(1, $crawler->filter('form[name="contact"]'));
    }

    /**
     * Test contact submit
     *
     * @return void
     */
    public function testContactSubmit()
    {   
        $this->client->enableProfiler();
        $crawler = $this->client->request('GET', '/');
        
        $form = $crawler->selectButton('Envoyer')->form();
        $form['contact[name]'] = 'name';
        $form['contact[email]'] = 'email@email.com';
        $form['contact[subject]'] = 'subject';
        $form['contact[content]'] = 'Contact message content';
        $form['contact[personalData]'] = '1';
        $crawler = $this->client->submit($form);

        $this->assertSame(1, $crawler->filter('div.alert-success')->count());
        $this->assertEmailCount(2);
    }
}