<?php

namespace App\Controller;

use App\Entity\Techno;
use App\Form\TechnoType;
use App\Manager\TechnoManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class TechnoController extends AbstractController
{
    /**
     * @var TechnoManager
     */
    private $technoManager;

    public function __construct(TechnoManager $technoManager)
    {
        $this->technoManager = $technoManager;
    }

    /**
     * @Route("/admin/technos", name="admin.techno.index")
     */
    public function adminIndex(): Response
    {
        $technos = $this->technoManager->findAll();
        
        return $this->render('techno/admin.index.html.twig', [
            'technos' => $technos,
            'dashboardnav' => 'techno.index'
        ]);
    }

}
