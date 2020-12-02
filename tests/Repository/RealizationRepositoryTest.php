<?php

namespace App\Tests\Repository;

use App\DataFixtures\TechnoFixtures;
use App\DataFixtures\RealizationFixtures;
use App\Repository\RealizationRepository;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class RealizationRepositoryTest extends KernelTestCase
{
    use FixturesTrait;

    public function testUserFixturesNumber()
    {
        self::bootKernel();
        $this->loadFixtures([TechnoFixtures::class, RealizationFixtures::class]);
        $realizations = self::$container->get(RealizationRepository::class)->count([]);
        $this->assertSame(10, $realizations);
    }
}