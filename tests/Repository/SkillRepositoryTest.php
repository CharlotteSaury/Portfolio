<?php

namespace App\Tests\Repository;

use App\DataFixtures\SkillFixtures;
use App\Repository\SkillRepository;
use App\DataFixtures\RealizationFixtures;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SkillRepositoryTest extends KernelTestCase
{
    use FixturesTrait;

    public function testSkillFixturesNumber()
    {
        self::bootKernel();
        $this->loadFixtures([SkillFixtures::class, RealizationFixtures::class]);
        $skills = self::$container->get(SkillRepository::class)->count([]);
        $this->assertSame(5, $skills);
    }
}