<?php

namespace App\Controller;

use App\Repository\ReseauRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function afficheContact(ReseauRepository $reseauRepository, UtilisateurRepository $utilisateurRepository)
    {
        $user = $utilisateurRepository->findOneBy(['email' => 'maxime.lopes@hotmail.com']);
        $reseaux = $reseauRepository->findBy(['id_utilisateur' => $user->getId()]);

        return $this->render(
            'contact.html.twig',
            [
                'titre' => "Contact",
                'reseaux' => $reseaux,
            ]
        );
    }
}