<?php

namespace App\Tests\Entity;

use App\Entity\Techno;
use App\DataFixtures\UserFixtures;
use App\DataFixtures\TechnoFixtures;
use App\Tests\Utils\AssertHasErrors;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TechnoTest extends KernelTestCase
{
    use AssertHasErrors;
    use FixturesTrait;

    public function getEntity(): Techno
    {
        $techno = new Techno();
        $techno->setTitle('valid title')
                ->setType('valid type')
                ->setLevel(3)
                ->setImage('validImageName');
        return $techno;
    }
    /**
     * Assert valid entity is valid.
     *
     * @return void
     */
    public function testValidTechnoEntity()
    {
        $validTechno = $this->getEntity();
        $this->assertHasErrors($validTechno, 0);
    }

    /**
     * Assert invalid blank entity (title, type) is invalid.
     *
     * @return void
     */
    public function testInvalidTechnoEntity()
    {
        $invalidTechno = new Techno();
        $invalidTechno->setTitle('');
        $invalidTechno->setType('');
        $invalidTechno->setLevel(0);
        $this->assertHasErrors($invalidTechno, 5);
    }

    /**
     * Assert techno unicity with title.
     *
     * @return void
     */
    public function testInvalidUniqueTitle()
    {
        $this->loadFixtures([TechnoFixtures::class, UserFixtures::class]);
        $invalidTechno = $this->getEntity();
        $invalidTechno->setTitle('techno1');
        $this->assertHasErrors($invalidTechno, 1);
    }

}