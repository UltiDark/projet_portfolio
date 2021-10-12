<?php

namespace App\Controller;

use App\Entity\Domaine;
use App\Entity\Capacite;
use App\Form\DomaineType;
use App\Form\CapaciteType;
use App\Repository\DomaineRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/domaine")
 */
class DomaineController extends AbstractController
{
    /**
     * @Route("/liste", name="listedomaine")
     */
    public function index(DomaineRepository $domaineRepository): Response
    {
        $domaine = $domaineRepository->findAll();
        return $this->render('home.html.twig', [
            'domaines' => $domaineRepository->findAll(),
            'titre' => 'Liste des Domaines'

        ]);
    }

    /**
     * @Route("/ajout", name="ajoutdomaine")
     */
    public function new(Request $request): Response
    {
        $tab = [];
        $mot = "";
        $domaine = new Domaine();
        $form = $this->createFormBuilder()
        ->add("Domaine_nom", DomaineType::class )
        ->add('Capacite', CapaciteType::class)
        ->add('submit', SubmitType::class, [
            'label' => 'Envoyer'
        ])
        ->getForm(); 

        $form->handleRequest($request);

        
        if ($form->isSubmitted() && $form->isValid()) {
            $nomCapacité = $form->get('Capacite')->get('nom')->getData();
            for($i = 0 ; $i < strlen($nomCapacité) ; $i++){
                if($nomCapacité[$i] == " " || $nomCapacité[$i] == "?" || $nomCapacité[$i] == ",")
                {
                    $mot = ucfirst($mot);
                    if ($mot > 1 && $mot != ""){
                        array_push($tab, $mot);
                    }
                    $mot = "";

                }
                elseif($nomCapacité[$i] == "_"){
                    $mot = $mot . " ";
                }
                else{
                    $mot = $mot . $nomCapacité[$i];
                }
            }
            array_push($tab, $mot);

            $entityManager = $this->getDoctrine()->getManager();


            for($i = 0; $i < count($tab); $i++){
                $capacite = new Capacite();
                $capacite->setNom($tab[$i]);
                $capacite->setIdGroupe($form->get('Capacite')->get('id_groupe')->getData());
                $entityManager->persist($capacite);
                $entityManager->flush();
                $domaine->addIdCapacite($capacite);
            }

            $domaine->setNom($form->get('Domaine_nom')->get('nom')->getData());
            
            $entityManager->persist($domaine);
            $entityManager->flush();

            return $this->redirectToRoute('accueil', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commun/new.html.twig', [
            'domaine' => $domaine,
            'form' => $form,
            'titre' => 'Ajout d\'un nouveau domaine'

        ]);
    }
/*
    #[Route('/{id}', name: 'domaine_show', methods: ['GET'])]
    public function show(Domaine $domaine): Response
    {
        return $this->render('domaine/show.html.twig', [
            'domaine' => $domaine,
            'titre' => 'Domaine'

        ]);
    }*/

    /**
     * @Route("/modif", name="modifdomaine")
     */
    public function edit(Request $request, Domaine $domaine): Response
    {
        $form = $this->createForm(DomaineType::class, $domaine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('domaine_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commun/edit.html.twig', [
            'domaine' => $domaine,
            'form' => $form,
            'titre' => 'Modification d\'un Domaine'
        ]);
    }

    /**
     * @Route("/sup", name="supdomaine")
     */
    public function delete(Request $request, Domaine $domaine): Response
    {
        if ($this->isCsrfTokenValid('delete'.$domaine->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($domaine);
            $entityManager->flush();
        }

        return $this->redirectToRoute('accueil', [], Response::HTTP_SEE_OTHER);
    }
}
