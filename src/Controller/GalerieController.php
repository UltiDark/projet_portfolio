<?php

namespace App\Controller;

use App\Entity\Galerie;
use App\Form\GalerieType;
use App\Repository\GalerieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/galeries")
 */
class GalerieController extends AbstractController
{

    /**
     * @Route("/ajout", name="ajoutgalerie")
     */
    public function ajoutGalerie(Request $request): Response
    {
        $galerie = new Galerie();
        $form = $this->createForm(GalerieType::class, $galerie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($galerie);
            $entityManager->flush();

            return $this->redirectToRoute('listegaleries', ['type' =>  $data->getIdCategorie()->getNom()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commun/new.html.twig', [
            'galerie' => $galerie,
            'form' => $form,
            'titre' => 'Ajout dans la galerie',
        ]);
    }

    /*#[Route('/{id}', name: 'Galerie_show', methods: ['GET'])]
    public function show(Galerie $galerie): Response
    {
        return $this->render('Galerie/show.html.twig', [
            'Galerie' => $galerie,
        ]);
    }*/

    /**
     * @Route("/modif/{id}", name="modifgalerie")
     */
    public function edit(Request $request, Galerie $galerie): Response
    {
        $form = $this->createForm(GalerieType::class, $galerie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('listegaleries', ['type' => $data->getIdCategorie()->getNom()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commun/edit.html.twig', [
            'galerie' => $galerie,
            'form' => $form,
            'titre' => 'Modification dans la galerie'
        ]);
    }

    /**
     * @Route("/sup/{id}", name="supgalerie")
     */
    public function delete(Request $requete, Galerie $galerie): Response
    {
        if ($this->isCsrfTokenValid('delete'.$galerie->getId(), $requete->query->get('csrf'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($galerie);
            $entityManager->flush();
        }

    return $this->redirectToRoute('listegaleries', ['type' => $galerie->getIdCategorie()->getNom()], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{type}", name="listegaleries")
     */
    public function afficheGaleries($type, GalerieRepository $repository){
        $_SESSION['role'] = "admin";
        $galeries = $repository->findByJoin($type);
        if ($type == "modelisation"){
            $titre = "Modélisations 3D";
        }
        elseif($type == "sprite"){
            $titre = "Sprites 2D";
        }

        return $this->render(
            'galerie/galeries.html.twig',
            [
                'titre' => $titre,
                'galeries' => $galeries,
                'autorisation' => $_SESSION['role'],
                'i' => 0
            ]);
    }

}
