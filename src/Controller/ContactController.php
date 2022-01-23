<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\Mime\Email;
use App\Repository\ReseauRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function afficheContact(ReseauRepository $reseauRepository, UtilisateurRepository $utilisateurRepository, Request $request, MailerInterface $mi)
    {
        $user = $utilisateurRepository->findOneBy(['email' => 'maxime.lopes@hotmail.com']);
        $reseaux = $reseauRepository->findBy(['id_utilisateur' => $user->getId()]);
        
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {        
            $email = new Email;
            $email
                ->from($form->getData()['mail'])
                ->to('compte.pro@lopes-maxime.com')
                ->subject($form->getData()['objet'])
                ->text($form->getData()['contenu']);
    
            $mi->send($email);
            $this->addFlash('success', 'Votre mail a bien été envoyé !');
    
            return $this->redirectToRoute('accueil');
        }
        elseif($form->isSubmitted()){
            $this->addFlash('error', 'Une erreur c\'est produite !');
        }


        return $this->render(
            'contact/contact.html.twig',
            [
                'titre' => "Contact",
                'reseaux' => $reseaux,
                'form' => $form->createView()
            ]
        );
    }
}