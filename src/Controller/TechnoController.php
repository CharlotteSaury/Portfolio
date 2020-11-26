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

    /**
     * @Route("/admin/techno/create", name="admin.techno.create")
     */
    public function create(Request $request): Response
    {
        $techno = new Techno();
        $form = $this->createForm(TechnoType::class, $techno);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $techno = $this->technoManager->handleCreateOrUpdate($techno);
            $this->addFlash('success', 'La technologie a bien été ajoutée !');

            return $this->redirectToRoute('admin.techno.index');
        }

        return $this->render('techno/new.html.twig', [
            'techno' => $techno,
            'form' => $form->createView(),
            'dashboardnav' => 'techno.create',
        ]);
    }

}
