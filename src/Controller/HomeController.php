<?php

namespace App\Controller;

use App\Manager\TechnoManager;
use App\Manager\RealizationManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @var TechnoManager
     */
    private $technoManager;

    /**
     * @var RealizationManager
     */
    private $realizationManager;

    public function __construct(TechnoManager $technoManager, RealizationManager $realizationManager)
    {
        $this->technoManager = $technoManager;
        $this->realizationManager = $realizationManager;
    }
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        $technos = $this->technoManager->findAll();
        $realizations = $this->realizationManager->findLast(5);
        
        return $this->render('home/index.html.twig', [
            'technos' => $technos,
            'realizations' => $realizations,
        ]);
    }
}
