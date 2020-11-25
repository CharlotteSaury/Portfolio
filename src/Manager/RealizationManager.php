<?php

namespace App\Manager;

use App\Entity\Realization;
use App\Repository\RealizationRepository;
use Doctrine\ORM\EntityManagerInterface;

class RealizationManager 
{
    /**
     * @var RealizationRepository
     */
    private $realizationRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(RealizationRepository $realizationRepository, EntityManagerInterface $entityManager)
    {
        $this->realizationRepository = $realizationRepository;
        $this->entityManager = $entityManager;
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

    public function handleCreateOrUpdate(Realization $realization)
    {
        if ($realization->getId() == null) {
            $this->entityManager->persist($realization);
        }
        $this->entityManager->flush();
        return $realization;
    }

}