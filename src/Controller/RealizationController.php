<?php

namespace App\Controller;

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
     * @Route("/portfolio", name="portfolio")
     */
    public function index(): Response
    {
        $realizations = $this->realizationManager->findAll();
        
        return $this->render('realization/index.html.twig', [
            'realizations' => $realizations,
        ]);
    }
}
