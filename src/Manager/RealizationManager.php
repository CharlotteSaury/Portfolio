<?php

namespace App\Manager;

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

}