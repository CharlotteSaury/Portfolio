<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Expectation;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\RealizationFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ExpectationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 5; $i++) {
            $expectation = new Expectation();
            $expectation->setDescription($faker->text)
                ->setRealization($this->getReference('realization'.(mt_rand(1, 10))));

            $manager->persist($expectation);
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
