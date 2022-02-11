<?php

namespace App\Controller;

use App\Entity\Contact;

use App\Form\CategorieType;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminContactController extends AbstractController
{
    /**
     * @Route("/admin/contact", name="admin_contact")
     */
    public function index(): Response
    {
        return $this->render('admin_contact/index.html.twig', [
            'controller_name' => 'AdminContactController',
        ]);
    }

    
   /**
     * @Route("/gestion_contact/afficher", name="contact_afficher")
    */
    public function afficher_contact(ContactRepository $repoContact)
    {

        $contact = $repoContact->findAll();

        return $this->render('admin_contact/contact_afficher.html.twig', [
            'contact' => $contact,
        ]);
    }


     /**
     * @Route("/gestion_contact/ajouter", name="contact_ajouter")
    */
    public function ajouter_contact(Request $request)
    {

        $contact = new Contact;

        $form = $this->createForm(ContactType::class, $contact);
        $form ->handlerequest($request);


        return $this->render('admin_contact/index.html.twig', [
            'formContact' => $form -> createView(),
        ]);
    }






}
