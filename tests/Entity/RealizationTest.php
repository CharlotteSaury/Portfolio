<?php

namespace App\Tests\Entity;

use DateTime;
use App\Entity\Techno;
use App\Entity\Expectation;
use App\Entity\Realization;
use App\DataFixtures\UserFixtures;
use App\Tests\Utils\AssertHasErrors;
use App\DataFixtures\RealizationFixtures;
use App\Entity\Skill;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class RealizationTest extends KernelTestCase
{
    use AssertHasErrors;
    use FixturesTrait;

    public function getEntity(): Realization
    {
        $realization = new Realization();
        $techno = new Techno();
        $techno->setTitle('techno')
            ->setLevel(5)
            ->setType('type');

        $expectation = new Expectation();
        $expectation->setDescription('expectation');

        $skill = new Skill();
        $skill->setDescription('skill');

        $realization->setTitle('title')
                ->setShortDesc('short description')
                ->setDescription('long description')
                ->setContext('context')
                ->setGithub('http://www.github.com')
                ->setUrl('http://www.url.com')
                ->setDefense('http://www.defense.com')
                ->setCreatedAt(new DateTime())
                ->setUpdatedAt(new DateTime())
                ->setImage('ImageName')
                ->addTechno($techno)
                ->addExpectation($expectation)
                ->addSkill($skill);
        return $realization;
    }

    /**
     * Assert valid entity is valid.
     *
     * @return void
     */
    public function testValidRealizationEntity()
    {
        $validRealization = $this->getEntity();
        $this->assertHasErrors($validRealization, 0);
    }

    /**
     * Assert invalid blank entity (title, type) is invalid.
     *
     * @return void
     */
    public function testInvalidRealizationEntity()
    {
        $invalidExpectation = new Expectation();
        $invalidExpectation->setDescription('e');

        $invalidSkill = new Skill();
        $invalidSkill->setDescription('e');
        
        $invalidRealization = new Realization();
        $invalidRealization->setTitle('')
                ->setShortDesc('')
                ->setDescription('')
                ->setContext('')
                ->setGithub('github')
                ->setUrl('url')
                ->setDefense('defense')
                ->addExpectation($invalidExpectation)
                ->addSkill($invalidSkill);
        $this->assertHasErrors($invalidRealization, 13);
    }

    /**
     * Assert realization unicity with title.
     *
     * @return void
     */
    public function testInvalidRealizationUniqueTitle()
    {
        $this->loadFixtures([RealizationFixtures::class]);
        $invalidRealization = $this->getEntity();
        $invalidRealization->setTitle('realization1');
        $this->assertHasErrors($invalidRealization, 1);
    }

}