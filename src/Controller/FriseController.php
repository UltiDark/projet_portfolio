<?php

namespace App\Controller;

use App\Entity\Frise;
use App\Form\FriseType;
use App\Repository\FriseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/frise")
 */
class FriseController extends AbstractController
{
    /**
     * @Route("/liste", name="listefrise")
     */
    public function index(FriseRepository $friseRepository, EntityManagerInterface $em): Response
    {
        $date = time();
        $test = $friseRepository->getByOrder();

        // affichage de l'entièreté des entité de la liste
        return $this->render('frise/index.html.twig', [
            'frises' => $friseRepository->getByOrder(),
            'titre' => 'Liste des informations de la frise',
            'date' => $date
        ]);
    }

    /**
     * @Route("/ajout", name="ajoutfrise")
     */
    public function new(Request $request): Response
    {
        // création d'une nouvelle entité
        $frise = new Frise();
        // création du formulaire lié à la frise
        $form = $this->createForm(FriseType::class, $frise);
        $form->handleRequest($request);

        // si le formulaire est conforme
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            // mise en place de la requête indiquant que la donnée selectionnée doit être ajouté
            $entityManager->persist($frise);
            // exécution de la requête de "insert"
            $entityManager->flush();

            // Retour liste frise
            return $this->redirectToRoute('listefrise', [], Response::HTTP_SEE_OTHER);
        }

        // affichage du formulaire
        return $this->renderForm('commun/new.html.twig', [
            'frise' => $frise,
            'form' => $form,
            'titre' => 'Ajout dans la frise'

        ]);
    }

    /**
     * @Route("/detail/{id}", name="detailfrise")
     */
    /*public function show(Frise $frise): Response
    {
        return $this->render('frise/show.html.twig', [
            'frise' => $frise,
            'titre' => 'Détail'
        ]);
    }*/

    /**
     * @Route("/modif/{id}", name="modiffrise")
     */
    public function edit(Request $request, Frise $frise): Response
    {
        // création du formulaire lié à la frise
        $form = $this->createForm(FriseType::class, $frise);

        $form->handleRequest($request);

        // si le formulaire est conforme
        if ($form->isSubmitted() && $form->isValid()) {
            // mise en place et execusion de la requete de "update"
            $this->getDoctrine()->getManager()->flush();
            
            // Retour liste frise
            return $this->redirectToRoute('listefrise', [], Response::HTTP_SEE_OTHER);
        }

        // affichage du formulaire
        return $this->renderForm('commun/edit.html.twig', [
            'frise' => $frise,
            'form' => $form,
            'titre' => 'Modification dans la Frise'
        ]);
    }

    /**
     * @Route("/sup/{id}", name="supfrise")
     */
    public function delete(Request $requete, Frise $frise): Response
    {

        // si le token CRSF et present et conforme
        if ($this->isCsrfTokenValid('delete'.$frise->getId(), $requete->query->get('csrf'))) {
            $entityManager = $this->getDoctrine()->getManager();
            // mise en place de la requête indiquant que la donnée selectionnée doit être supprimée
            $entityManager->remove($frise);
            // exécution de la requête de "delete"
            $entityManager->flush();
        }
        else{
            return $this->redirectToRoute('accueil');

        }

        // Retour liste frise
        return $this->redirectToRoute('listefrise', [], Response::HTTP_SEE_OTHER);
    }
}
