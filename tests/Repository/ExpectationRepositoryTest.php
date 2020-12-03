<?php

namespace App\Tests\Repository;

use App\DataFixtures\ExpectationFixtures;
use App\DataFixtures\RealizationFixtures;
use App\Repository\ExpectationRepository;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ExpectationRepositoryTest extends KernelTestCase
{
    use FixturesTrait;

    public function testExpectationFixturesNumber()
    {
        self::bootKernel();
        $this->loadFixtures([ExpectationFixtures::class, RealizationFixtures::class]);
        $expectations = self::$container->get(ExpectationRepository::class)->count([]);
        $this->assertSame(5, $expectations);
    }
}