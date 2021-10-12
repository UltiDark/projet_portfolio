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
        $domaine = $domaineRepository->getDomaine();
        $domaines = [];
        $regroupement=[];

        for ($i = 0; $i<count($domaine); $i++)
        {
            array_push($regroupement, $domaine[$i]);
            if(!empty($domaine[$i-1]) && $domaine[$i-1]['domaine'] == $domaine[$i]['domaine']){
                array_push($regroupement, $domaine[$i]);
            }
            else{
                if (empty($regroupement))
                array_push($domaines, $domaine[$i]);
                else{
                    array_push($domaines, $regroupement);
                }
            }
        }

        //dd($domaines);
        $frises = $friseRepository->getByOrder();
        return $this->render(
            'home.html.twig',
            [
                'titre' => "Accueil",
                'domaines' => $domaines,
                'frises' => $frises,
            ]);
    }
}
