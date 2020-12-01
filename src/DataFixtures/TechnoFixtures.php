<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Techno;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class TechnoFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');
        $images = [
            'html5.png',
            'css3.png',
            'php.png',
            'symfony.png',
            'docker.png',
            'javascript.png',
            'bootstrap.png',
        ];

        $types = [
            'Frontend',
            'Backend',
            'Other'
        ];

        for ($i = 0; $i < count($images); $i++) {
            $techno = new Techno();
            $techno->setTitle($faker->word)
                ->setImage($images[$i])
                ->setType($types[mt_rand(0,2)])
                ->setLevel(mt_rand(2, 5));
            

            $manager->persist($techno);
            $this->addReference('techno'.$i, $techno);
        }

        $manager->flush();
    }
};
