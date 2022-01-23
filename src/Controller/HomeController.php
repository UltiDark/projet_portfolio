<?php

namespace App\Controller;

use App\Repository\FriseRepository;
use App\Repository\DomaineRepository;
use App\Repository\UtilisateurRepository;
use App\Repository\GalerieRepository;
use App\Repository\IntroRepository;
use App\Repository\ProjetRepository;
use App\Repository\ReseauRepository;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function afficheAccueil(DomaineRepository $domaineRepository, FriseRepository $friseRepository, IntroRepository $introRepository){
        
        $intros= $introRepository->getByOrder();
        $domaines = $domaineRepository->getDomaine();
        $frises = $friseRepository->getByOrder();

        return $this->render(
            'home.html.twig',
            [
                'titre' => "Accueil",
                'intros' => $intros,
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
                'titre2' => "CGU",

            ]);
    }

    /**
     * @Route("/politique", name="politique")
     */
    public function affichePolique(){
        
        return $this->render(
            'politique.html.twig',
            [
                'titre' => 'Mentions Légales',
                'titre2' => "Mentions Légales",

            ]);
    }

        /**
     * @Route("/dashboard", name="dashboard")
     */
    public function afficheDashboard(
        DomaineRepository $domaineRepository,
        FriseRepository $friseRepository,
        UtilisateurRepository $utilisateurRepository,
        ReseauRepository $reseauRepository,
        GalerieRepository $galerieRepository,
        ProjetRepository $projetRepository,

        ){

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render(
            'dashboard.html.twig',
            [
                'titre' => 'Dashboard',
                'titre2' => "Dashboard",
                'domaines' => $domaineRepository->getGroupe(),
                'frises' => $friseRepository->getByOrder(),
                'utilisateurs' => $utilisateurRepository->findAll(),
                'reseaux' => $reseauRepository->findAll(),
                'galeries' => $galerieRepository->findAll(),
                'projets' => $projetRepository->findAll()

            ]);
    }
}
