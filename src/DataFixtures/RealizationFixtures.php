<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Realization;
use App\DataFixtures\TechnoFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class RealizationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $realization = new Realization();
            $realization->setTitle('realization'.$i)
                ->setShortDesc($faker->sentence)
                ->setDescription($faker->text)
                ->setCreatedAt($faker->datetime)
                ->setUpdatedAt($faker->datetime)
                ->setContext($faker->word)
                ->setGithub($faker->url)
                ->setUrl($faker->url)
                ->setDefense($faker->url)
                ->setImage($faker->word);

                for ($j = 1; $j < 5; $j++) {
                    $realization->addTechno($this->getReference('techno'.mt_rand(0, 6)));
                }

            $manager->persist($realization);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            TechnoFixtures::class,
        ];
    }
}
