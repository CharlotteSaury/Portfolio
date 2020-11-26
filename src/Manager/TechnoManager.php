<?php

namespace App\Manager;

use App\Entity\Techno;
use App\Repository\TechnoRepository;
use Doctrine\ORM\EntityManagerInterface;

class TechnoManager 
{
    /**
     * @var TechnoRepository
     */
    private $technoRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(TechnoRepository $technoRepository, EntityManagerInterface $entityManager)
    {
        $this->technoRepository = $technoRepository;
        $this->entityManager = $entityManager;
    }

    public function findAll()
    {
        return $this->technoRepository->findAll();
    }

    public function handleCreateOrUpdate(Techno $techno)
    {
        if ($techno->getId() == null) {
            $this->entityManager->persist($techno);
        }
        $techno->setUpdatedAt(new \DateTime());
        $this->entityManager->flush();
        return $techno;
    }

}