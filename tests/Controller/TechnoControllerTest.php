<?php

namespace App\Tests\Controller;

use App\Tests\Utils\NeedLogin;
use App\DataFixtures\UserFixtures;
use App\DataFixtures\TechnoFixtures;
use App\DataFixtures\RealizationFixtures;
use Symfony\Component\HttpFoundation\Response;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TechnoControllerTest extends WebTestCase
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
     * Test Redirection to login route for visitors trying to access pages that require admin role.
     *
     * @dataProvider provideAuthenticatedUserAccessibleUrls
     */
    public function testUnaccessibleTechnoPagesNotAuthenticated($method, $url)
    {
        $this->client->request($method, $url);
        $this->assertResponseRedirects('/login');
    }

    public function provideAuthenticatedUserAccessibleUrls()
    {
        return [
            ['GET', '/admin/technos'],
            ['GET', '/admin/techno/create'],
            ['GET', '/admin/techno/edit/1'],
            ['DELETE', '/admin/techno/delete/1'],
        ];
    }

    /**
     * Test access to restricted pages related to technos for admin
     *
     * @return void
     */
    public function testRestrictedPageAccessAuthenticated()
    {
        $routes = [
            ['GET', '/admin/technos'],
            ['GET', '/admin/techno/create'],
            ['GET', '/admin/techno/edit/1'],
        ];
        $this->login($this->client, $this->getUser('admin@email.fr'));
        foreach ($routes as $route) {
            $this->client->request($route[0], $route[1]);
            $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        }
    }

    /**
     * Test integration of technos page
     *
     * @return void
     */
    public function testIntegrationTechnosPage()
    {
        $this->login($this->client, $this->getUser('admin@email.fr'));
        $crawler = $this->client->request('GET', '/admin/technos');
        $this->assertSame(1, $crawler->filter('h3:contains("Toutes les technologies")')->count());
        $this->assertCount(1, $crawler->filter('table'));
        $this->assertSame(7, $crawler->filter('tr')->count());
    }

    /**
     * Test integration of techno creation page for admin
     *
     * @return void
     */
    public function testIntegrationTechnoCreationPage()
    {
        $this->login($this->client, $this->getUser('admin@email.fr'));
        $crawler = $this->client->request('GET', '/admin/techno/create');

        $this->assertSelectorExists('form');
        $this->assertCount(5, $crawler->filter('input'));
        $this->assertSame(1, $crawler->filter('input[placeholder="Titre"]')->count());
        $this->assertSame(1, $crawler->filter('input[placeholder="Type"]')->count());
        $this->assertSame(1, $crawler->filter('input[placeholder="Niveau"]')->count());
        $this->assertSame(1, $crawler->filter('input[type="file"]')->count());
        $this->assertSame(1, $crawler->filter('button:contains("Ajouter")')->count());
    }

    /**
     * Test new techno creation
     *
     * @return void
     */
    public function testTechnoCreation()
    {
        $this->login($this->client, $this->getUser('admin@email.fr'));
        $crawler = $this->client->request('GET', '/admin/techno/create');

        $form = $crawler->selectButton('Ajouter')->form();
        $form['techno[title]'] = 'new techno';
        $form['techno[type]'] = 'Backend';
        $form['techno[level]'] = 3;
        
        $file = $this->getMockBuilder('Symfony\Component\HttpFoundation\File\File')
            ->disableOriginalConstructor()
            ->getMock();
        $form['techno[imageFile]'] = $file;
        $this->client->submit($form);

        $this->assertResponseRedirects('/admin/technos');
        $crawler = $this->client->followRedirect();
        $this->assertSame(1, $crawler->filter('div.alert-success')->count());
        $this->assertSame(1, $crawler->filter('td:contains("new techno")')->count());
    }

    /**
     * Test integration of techno edition page for admin
     *
     * @return void
     */
    public function testIntegrationTechnoEditionPage()
    {
        $this->login($this->client, $this->getUser('admin@email.fr'));
        $crawler = $this->client->request('GET', '/admin/techno/edit/1');

        $this->assertSelectorExists('form');
        $this->assertCount(5, $crawler->filter('input'));
        $this->assertSame(1, $crawler->filter('input[value="techno1"]')->count());
        $this->assertSame(1, $crawler->filter('input[value="Frontend"]')->count());
        $this->assertSame(1, $crawler->filter('input[type="file"]')->count());
        $this->assertSame(1, $crawler->filter('button:contains("Editer")')->count());
    }

    /**
     * Test new techno edition
     *
     * @return void
     */
    public function testTechnoEdition()
    {
        $this->login($this->client, $this->getUser('admin@email.fr'));
        $crawler = $this->client->request('GET', '/admin/techno/edit/1');

        $form = $crawler->selectButton('Editer')->form();
        $form['techno[title]'] = 'updated title';
        $form['techno[type]'] = 'updated type';
        $form['techno[level]'] = 5;
        $this->client->submit($form);

        $this->assertResponseRedirects('/admin/technos');
        $crawler = $this->client->followRedirect();
        $this->assertSame(1, $crawler->filter('div.alert-success')->count());
        $this->assertSame(1, $crawler->filter('td:contains("updated title")')->count());
    }

    /**
     * Test delete action by admin
     *
     * @return void
     */
    public function testTechnoDeletion()
    {
        $this->login($this->client, $this->getUser('admin@email.fr'));

        $csrfToken = $this->client->getContainer()->get('security.csrf.token_manager')->getToken('techno_deletion_1');
        $crawler = $this->client->request('POST', '/admin/techno/delete/1', [
            '_token' => $csrfToken,
            '_methods' => 'DELETE'
        ]);
        $this->assertResponseRedirects('/admin/technos');
        $crawler = $this->client->followRedirect();
        $this->assertSame(1, $crawler->filter('div.alert-success')->count());
        $this->assertSame(0, $crawler->filter('td:contains("techno1")')->count());
    }
}