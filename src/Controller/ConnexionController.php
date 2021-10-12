<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ConnexionController extends AbstractController
{
    /**
     * @Route("/connexion/{route}", name="connexion")
     */
    public function afficheConnexion($route)
    {
        $titre = ucfirst($route);
        return $this->render(
            'connexion.html.twig',
            [
                'titre' => $titre,
            ]
        );
    }
}
