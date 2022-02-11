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
use Doctrine\ORM\EntityManagerInterface;

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
    public function ajouter_contact(Request $request, EntityManagerInterface $manager)
    {

        $contact = new Contact;
        

        $form = $this->createForm(ContactType::class, $contact);
        $form ->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) 
        { 
            //dd($request);
            $manager->persist($contact); // définir l'objet a envoyer
            $manager->flush(); // envoyer
            $this ->addFlash ('success', "Bonjour " . $contact->getPrenom() . " a bien été ajoutée");
            return $this->redirectToRoute("contact_afficher");

        }


        return $this->render('admin_contact/index.html.twig', [
            'formContact' => $form -> createView(),

        ]);
    }

     /**
     * @Route("/gestion_contact/modifier/{id}", name="contact_modifier")
    */
    public function modifier_contact(Contact $contact , Request $request, EntityManagerInterface $manager)
    {
 
        $form = $this->createForm(ContactType::class, $contact);
        $form ->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) 
        { 
            //dd($request);
            $manager->persist($contact); // définir l'objet a envoyer
            $manager->flush(); // envoyer
            $this ->addFlash ('success', "Votre fiche contact " . $contact->getPrenom() . " a bien été modifiée");
            return $this->redirectToRoute("contact_afficher");

        }


        return $this->render('admin_contact/index.html.twig', [
            'formContact' => $form -> createView(),

        ]);
    }

       /**
     * @Route("/gestion_contact/supprimer/{id}", name="contact_supprimer")
    */
    public function supprimer_contact(Contact $contact , EntityManagerInterface $manager): Response
    {
 
            $prenomContact = $contact->getPrenom();
            $nomContact = $contact->getNom();

            $manager->remove($contact); 
            $manager->flush();
            $this ->addFlash ('success', "Votre fiche contact " . $prenomContact .$nomContact . " a bien été supprimée");
            return $this->redirectToRoute("contact_afficher");

        
        
    }






}
