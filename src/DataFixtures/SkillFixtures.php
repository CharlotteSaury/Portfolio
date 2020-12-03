<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Skill;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\RealizationFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class SkillFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 5; $i++) {
            $skill = new Skill();
            $skill->setDescription($faker->text)
                ->setRealization($this->getReference('realization'.(mt_rand(1, 10))));

            $manager->persist($skill);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            RealizationFixtures::class,
        ];
    }
}
