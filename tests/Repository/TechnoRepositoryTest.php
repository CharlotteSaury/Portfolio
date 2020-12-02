<?php

namespace App\Tests\Repository;

use App\DataFixtures\TechnoFixtures;
use App\Repository\TechnoRepository;
use App\DataFixtures\RealizationFixtures;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TechnoRepositoryTest extends KernelTestCase
{
    use FixturesTrait;

    public function testUserFixturesNumber()
    {
        self::bootKernel();
        $this->loadFixtures([TechnoFixtures::class, RealizationFixtures::class]);
        $technos = self::$container->get(TechnoRepository::class)->count([]);
        $this->assertSame(6, $technos);
    }
}