<?php

namespace App\Controller;

use App\Entity\Realization;
use App\Form\RealizationType;
use App\Manager\TechnoManager;
use App\Manager\RealizationManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

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

    /**
     * @Route("/admin/realisations", name="admin.realization.index")
     */
    public function adminIndex(): Response
    {
        $realizations = $this->realizationManager->findAll();
        
        return $this->render('realization/admin.index.html.twig', [
            'realizations' => $realizations,
        ]);
    }

    /**
     * @Route("/realisation/create", name="realization.create")
     */
    public function create(Request $request): Response
    {
        $realization = new Realization();
        $form = $this->createForm(RealizationType::class, $realization);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $realization = $this->realizationManager->handleCreateOrUpdate($realization);
            $this->addFlash('success', 'La réalisation a bien été créée');

            return $this->redirectToRoute('realization.show', [
                'id' => $realization->getId(),
                'slug' => $realization->getSlug(),
            ]);
        }

        return $this->render('realization/new.html.twig', [
            'realization' => $realization,
            'form' => $form->createView(),
            'dashboardnav' => 'realization.create',
        ]);
    }

    /**
     * @Route("/realisation/{id}/edit", name="realization.edit")
     */
    public function edit(Realization $realization, Request $request): Response
    {
        $form = $this->createForm(RealizationType::class, $realization);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $realization = $this->realizationManager->handleCreateOrUpdate($realization);
            $this->addFlash('success', 'La réalsiation a été modifiée');

            return $this->redirectToRoute('realization.show', [
                'id' => $realization->getId(),
                'slug' => $realization->getSlug(),
            ]);
        }

        return $this->render('realization/new.html.twig', [
            'realization' => $realization,
            'form' => $form->createView(),
            'dashboardnav' => 'realization.edit',
        ]);
    }
}
