<?php

namespace App\Controller;

use App\Repository\DomaineRepository;
use App\Repository\FriseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function afficheAccueil(DomaineRepository $domaineRepository, FriseRepository $friseRepository){
        
        $domaines = $domaineRepository->getDomaine();

        $frises = $friseRepository->getByOrder();
        return $this->render(
            'home.html.twig',
            [
                'titre' => "Accueil",
                'domaines' => $domaines,
                'frises' => $frises,
            ]);
    }

        /**
     * @Route("/cgu", name="cgu")
     */
    public function afficheCGU(){
        
        return $this->render(
            'cgu.html.twig',
            [
                'titre' => 'CGU',
                'titre2' => "Mentions Légales",

            ]);
    }
}
