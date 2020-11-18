<?php

namespace App\Manager;

use App\Repository\TechnoRepository;

class TechnoManager 
{
    private $technoRepository;

    public function __construct(TechnoRepository $technoRepository)
    {
        $this->technoRepository = $technoRepository;
    }

    public function allTechno()
    {
        return $this->technoRepository->findAll();
    }

}