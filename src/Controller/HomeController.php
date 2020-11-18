<?php

namespace App\Controller;

use App\Manager\TechnoManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    private $technoManager;

    public function __construct(TechnoManager $technoManager)
    {
        $this->technoManager = $technoManager;
    }
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        $technos = $this->technoManager->allTechno();
        
        return $this->render('home/index.html.twig', [
            'technos' => $technos,
        ]);
    }
}
