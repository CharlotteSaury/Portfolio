<?php

namespace App\Manager;

use App\Entity\Realization;
use App\Repository\RealizationRepository;

class RealizationManager 
{
    private $realizationRepository;

    public function __construct(RealizationRepository $realizationRepository)
    {
        $this->realizationRepository = $realizationRepository;
    }

    public function findAll()
    {
        return $this->realizationRepository->findBy(array(), array('createdAt' => 'DESC'));
    }

    public function findLast(int $number)
    {
        return $this->realizationRepository->findBy(array(), array('createdAt' => 'DESC'), $number);
    }

    public function getPrevious(Realization $realization)
    {
        $previousRealization = $this->realizationRepository->findOneBy(['id' => ($realization->getId() - 1) ]);
        if ($previousRealization) {
            return $previousRealization;
        }
        return null;
    }

    public function getNext(Realization $realization)
    {
        $nextRealization = $this->realizationRepository->findOneBy(['id' => ($realization->getId() + 1) ]);
        if ($nextRealization) {
            return $nextRealization;
        }
        return null;
    }

}