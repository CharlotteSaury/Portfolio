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
        $images = [
            'html5.png',
            'css3.png',
            'php.png',
            'symfony.png',
            'docker.png',
            'javascript.png',
        ];

        for ($i = 1 ; $i < 7; $i++) {
            $techno = new Techno();
            $techno->setTitle('techno'.$i)
                ->setImage($images[$i-1])
                ->setLevel(mt_rand(2, 5));

            switch ($i) {
                case ($i === 1 || $i === 2 ):
                    $type = 'Frontend';
                    break;
                case ($i === 3 || $i === 4 ):
                    $type = 'Backend';
                    break;
                default:
                    $type = 'Other';            
            }
            $techno->setType($type);
                
            $manager->persist($techno);
            $this->addReference('techno'.$i, $techno);
        }
        

        $manager->flush();
    }
};
