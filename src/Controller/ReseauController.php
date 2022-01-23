<?php

namespace App\Controller;

use App\Entity\Reseau;
use App\Form\ReseauType;
use App\Repository\ReseauRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/reseau")
 */
class ReseauController extends AbstractController
{
    /**
     * @Route("/liste", name="listereseaux")
     */
    public function index(ReseauRepository $reseauRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('reseau/index.html.twig', [
            'reseaux' => $reseauRepository->findAll(),
            'titre' => "Liste des réseaux sociaux"
        ]);
    }


    /**
     * @Route("/ajout", name="ajoutreseau")
     */
    public function new(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $reseau = new Reseau();
        $form = $this->createForm(ReseauType::class, $reseau);
        $form->handleRequest($request);

        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $reseau->setIdUtilisateur($user);
            $entityManager->persist($reseau);
            $entityManager->flush();
            $this->addFlash('success', 'Un nouveau réseau social a bien été ajouté !');
            return $this->redirectToRoute('listereseaux', [], Response::HTTP_SEE_OTHER);
        }
        elseif($form->isSubmitted()){
            $this->addFlash('error', 'Une erreur c\'est produite !');
        }

        return $this->renderForm('commun/new.html.twig', [
            'reseau' => $reseau,
            'form' => $form,
            'titre' => 'Réseau Social',
            'titre2' => 'Nouveau Réseau Social'
        ]);
    }

    /**
     * @Route("/modif/{id}", name="modifreseau")
     */
    public function edit(Request $request, Reseau $reseau): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(ReseauType::class, $reseau);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Le réseau social a bien été modifié !');
            return $this->redirectToRoute('listereseaux', [], Response::HTTP_SEE_OTHER);
        }
        elseif($form->isSubmitted()){
            $this->addFlash('error', 'Une erreur c\'est produite !');
        }

        return $this->renderForm('commun/edit.html.twig', [
            'reseau' => $reseau,
            'form' => $form,
            'titre' => 'Réseau Social',
            'titre2' => 'Modif Réseau Social'

        ]);
    }

    /**
     * @Route("/sup/{id}", name="supreseau")
     */
    public function delete(Request $requete, Reseau $reseau): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        if ($this->isCsrfTokenValid('delete'.$reseau->getId(), $requete->query->get('csrf'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($reseau);
            $entityManager->flush();
            $this->addFlash('success', 'Le réseau social a bien été supprimé !');

        }
        else{
            $this->addFlash('error', 'Une erreur c\'est produite !');
        }

        return $this->redirectToRoute('dashboard', [], Response::HTTP_SEE_OTHER);
    }
}
