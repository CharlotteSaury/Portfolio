<?php

namespace App\Controller;

use App\Entity\Realization;
use App\Manager\TechnoManager;
use App\Manager\RealizationManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RealizationController extends AbstractController
{
    /**
     * @var RealizationManager
     */
    private $realizationManager;

    public function __construct(RealizationManager $realizationManager)
    {
        $this->realizationManager = $realizationManager;
    }

    /**
     * @Route("/portfolio", name="realization.index")
     */
    public function index(): Response
    {
        $realizations = $this->realizationManager->findAll();
        
        return $this->render('realization/index.html.twig', [
            'realizations' => $realizations,
        ]);
    }

    /**
     * @Route("/realisation/{id}/{slug}", name="realization.show")
     */
    public function show(Realization $realization): Response
    {
        $previousRealization = $this->realizationManager->getPrevious($realization);
        $nextRealization = $this->realizationManager->getNext($realization);

        return $this->render('realization/show.html.twig', [
            'realization' => $realization,
            'previous' => $previousRealization,
            'next' => $nextRealization,
        ]);
    }
}
