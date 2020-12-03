<?php

namespace App\Tests\Controller;

use App\Tests\Utils\NeedLogin;
use App\DataFixtures\UserFixtures;
use App\DataFixtures\TechnoFixtures;
use App\DataFixtures\RealizationFixtures;
use Symfony\Component\HttpFoundation\Response;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RealizationControllerTest extends WebTestCase
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
     * Test access to realization index page
     *
     * @return void
     */
    public function testIndexNotAuthenticated()
    {
        $crawler = $this->client->request('GET', '/portfolio');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSame(1, $crawler->filter('h2:contains("Mes réalisations")')->count());
        $this->assertCount(10, $crawler->filter('div.realization-card'));
    }

    /**
     * Test access to realization show page
     *
     * @return void
     */
    public function testShowNotAuthenticated()
    {
        $crawler = $this->client->request('GET', '/realisation/1/realisation1');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSame(1, $crawler->filter('h2:contains("realization1")')->count());
    }

    /**
     * Test Redirection to login route for visitors trying to access pages that require admin role.
     *
     * @dataProvider provideAdminRestrictedPages
     */
    public function testAdminRestrictedPagesNotAuthenticated($method, $url)
    {
        $this->client->request($method, $url);
        $this->assertResponseRedirects('/login');
    }

    public function provideAdminRestrictedPages()
    {
        return [
            ['GET', '/admin/realisations'],
            ['GET', '/admin/realisation/create'],
            ['GET', '/admin/realisation/edit/1'],
            ['DELETE', '/admin/realisation/delete/1'],
        ];
    }

    /**
     * Test access to restricted pages related to realizations for admin
     *
     * @return void
     */
    public function testAdminRestrictedPageAccess()
    {
        $routes = [
            ['GET', '/admin/realisations'],
            ['GET', '/admin/realisation/create'],
            ['GET', '/admin/realisation/edit/1'],
        ];
        $this->login($this->client, $this->getUser('admin@email.fr'));
        foreach ($routes as $route) {
            $this->client->request($route[0], $route[1]);
            $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        }
    }

    /**
     * Test integration of admin index realizations page
     *
     * @return void
     */
    public function testIntegrationAdminIndexRealizationsPage()
    {
        $this->login($this->client, $this->getUser('admin@email.fr'));
        $crawler = $this->client->request('GET', '/admin/realisations');
        $this->assertSame(1, $crawler->filter('h3:contains("Toutes les réalisations")')->count());
        $this->assertCount(1, $crawler->filter('table'));
        $this->assertSame(11, $crawler->filter('tr')->count());
    }

    /**
     * Test integration of realization creation page for admin
     *
     * @return void
     */
    public function testIntegrationRealizationCreationPage()
    {
        $this->login($this->client, $this->getUser('admin@email.fr'));
        $crawler = $this->client->request('GET', '/admin/realisation/create');

        $this->assertSelectorExists('form');
        $this->assertCount(8, $crawler->filter('input'));
        $this->assertSame(1, $crawler->filter('input[placeholder="Titre"]')->count());
        $this->assertSame(1, $crawler->filter('input[placeholder="Contexte"]')->count());
        $this->assertSame(1, $crawler->filter('input[type="file"]')->count());
        $this->assertSame(1, $crawler->filter('button:contains("attente")')->count());
        $this->assertSame(1, $crawler->filter('button:contains("compétence")')->count());
        $this->assertSame(1, $crawler->filter('button:contains("Ajouter")')->count());
    }

    /**
     * Test new realization creation
     *
     * @return void
     */
    public function testRealizationCreation()
    {
        $this->login($this->client, $this->getUser('admin@email.fr'));
        $crawler = $this->client->request('GET', '/admin/realisation/create');

        $form = $crawler->selectButton('Ajouter')->form();
        $form['realization[title]'] = 'new realization';
        $form['realization[context]'] = 'context';        
        $file = $this->getMockBuilder('Symfony\Component\HttpFoundation\File\File')
            ->disableOriginalConstructor()
            ->getMock();
        $form['realization[imageFile]'] = $file;
        $form['realization[shortDesc]'] = 'Short description'; 
        $form['realization[description]'] = 'Long description';
        $this->client->submit($form);

        $this->assertResponseRedirects('/realisation/11/new_realization');
        $crawler = $this->client->followRedirect();
        $this->assertSame(1, $crawler->filter('h2:contains("new realization")')->count());
    }

    /**
     * Test integration of realization edition page for admin
     *
     * @return void
     */
    public function testIntegrationRealizationEditionPage()
    {
        $this->login($this->client, $this->getUser('admin@email.fr'));
        $crawler = $this->client->request('GET', '/admin/realisation/edit/1');

        $this->assertSelectorExists('form');
        $this->assertCount(8, $crawler->filter('input'));
        $this->assertSame(1, $crawler->filter('input[value="realization1"]')->count());
        $this->assertSame(1, $crawler->filter('button:contains("Editer")')->count());
    }

    /**
     * Test realization edition
     *
     * @return void
     */
    public function testRealizationEdition()
    {
        $this->login($this->client, $this->getUser('admin@email.fr'));
        $crawler = $this->client->request('GET', '/admin/realisation/edit/1');

        $form = $crawler->selectButton('Editer')->form();
        $form['realization[title]'] = 'updated title';
        $form['realization[context]'] = 'new context';
        $form['realization[shortDesc]'] = 'New short description'; 
        $form['realization[description]'] = 'New long description';
        $this->client->submit($form);

        $this->assertResponseRedirects('/admin/realisations');
        $crawler = $this->client->followRedirect();
        $this->assertSame(1, $crawler->filter('div.alert-success')->count());
        $this->assertSame(1, $crawler->filter('td:contains("updated title")')->count());
    }

    /**
     * Test delete action by admin
     *
     * @return void
     */
    public function testRealizationDeletion()
    {
        $this->login($this->client, $this->getUser('admin@email.fr'));

        $csrfToken = $this->client->getContainer()->get('security.csrf.token_manager')->getToken('realization_deletion_1');
        $crawler = $this->client->request('POST', '/admin/realisation/delete/1', [
            '_token' => $csrfToken,
            '_methods' => 'DELETE'
        ]);
        $this->assertResponseRedirects('/admin/realisations');
        $crawler = $this->client->followRedirect();
        $this->assertSame(1, $crawler->filter('div.alert-success')->count());
        $this->assertSame(0, $crawler->filter('td:contains("realisation1")')->count());
    }
}