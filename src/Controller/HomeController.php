<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Manager\TechnoManager;
use App\Manager\ContactManager;
use App\Manager\RealizationManager;
use Symfony\Component\HttpFoundation\Request;
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
    public function index(Request $request, ContactManager $contactManager): Response
    {
        $technos = $this->technoManager->findAll();
        $realizations = $this->realizationManager->findLast(5);

        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactManager->handleContactForm($contact);
            $this->addFlash('success', 'Votre email a bien été envoyé. Je vous répondrai dans les plus brefs délais ! :)');
            $this->redirectToRoute('home', [
                '_fragment' => '#contactForm',
            ]);
        }
        
        return $this->render('home/index.html.twig', [
            'technos' => $technos,
            'realizations' => $realizations,
            'mozaic' => true,
            'contact' => $form->createView()
        ]);
    }
}
