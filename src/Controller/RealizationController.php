<?php

namespace App\Controller;

use App\Entity\Realization;
use App\Form\RealizationType;
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
            'dashboardnav' => 'realization.index'
        ]);
    }

    /**
     * @Route("/admin/realisation/create", name="realization.create")
     */
    public function create(Request $request): Response
    {
        $realization = new Realization();
        $form = $this->createForm(RealizationType::class, $realization);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $realization = $this->realizationManager->handleCreateOrUpdate($realization);

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
     * @Route("/admin/realisation/edit/{id}", name="realization.edit")
     */
    public function edit(Realization $realization, Request $request): Response
    {
        $form = $this->createForm(RealizationType::class, $realization);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
    
            $realization = $this->realizationManager->handleCreateOrUpdate($realization);
            $this->addFlash('success', 'La réalisation a bien été modifiée');

            return $this->redirectToRoute('admin.realization.index');
        }

        return $this->render('realization/new.html.twig', [
            'realization' => $realization,
            'form' => $form->createView(),
            'action' => 'edit'
        ]);
    }

    /**
     * @Route("/admin/realisation/delete/{id}", name="realization.delete")
     *
     * @return Response
     */
    public function delete(Request $request, Realization $realization)
    {
        if ($this->isCsrfTokenValid('realization_deletion_'.$realization->getId(), $request->get('_token'))) {
            $this->realizationManager->handleRealizationDeletion($realization);

            $this->addFlash('success', 'La réalisation a bien été supprimée !');

            return $this->redirectToRoute('admin.realization.index');
        }
        $this->addFlash('error', 'Une erreur est survenue');

        return $this->redirectToRoute('admin.realization.index');
    }
}
