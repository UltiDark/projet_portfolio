<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Form\ProjetType;
use App\Repository\CategorieRepository;
use App\Repository\ProjetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/projets")
 */
class ProjetController extends AbstractController
{

    /**
     * @Route("/ajout/{type}", name="ajoutprojet")
     */
    public function new($type, Request $request, CategorieRepository $categorieRepository, SluggerInterface $slugger): Response
    {
        $projet = new Projet();
        $form = $this->createForm(ProjetType::class, $projet);
        $categorie = $categorieRepository->findOneBy(['nom'=>$type]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lienFile = $form->get('lien')->getData();
            if ($lienFile) {
                $originalFilename = pathinfo($lienFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = 'img/'.$safeFilename.'-'.uniqid().'.'.$lienFile->guessExtension();
                try {
                    $lienFile->move(
                        $this->getParameter('img_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $projet->setLien($newFilename);
            }
            $data = $form->getData();
            $projet->setIdCategorie($categorie);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($projet);
            $entityManager->flush();

            return $this->redirectToRoute('listeprojets', ['type' =>  $data->getIdCategorie()->getNom()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commun/new.html.twig', [
            'projet' => $projet,
            'form' => $form,
            'titre' => "Ajout $type",

        ]);
    }

    /*#[Route('/{id}', name: 'projet_show', methods: ['GET'])]
    public function show(Projet $projet): Response
    {
        return $this->render('projet/show.html.twig', [
            'projet' => $projet,
        ]);
    }*/

    /**
     * @Route("/modif/{id}", name="modifprojet")
     */
    public function edit(Request $request, Projet $projet): Response
    {
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('listeprojets', ['type' => $data->getIdCategorie()->getNom()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commun/edit.html.twig', [
            'projet' => $projet,
            'form' => $form,
            'titre' => "Modification".$projet->getNom(),

        ]);
    }

    /**
     * @Route("/sup/{id}", name="supprojet")
     */
    public function delete(Request $requete, Projet $projet): Response
    {
        if ($this->isCsrfTokenValid('delete'.$projet->getId(), $requete->query->get('csrf'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($projet);
            $entityManager->flush();
        }

        return $this->redirectToRoute('listeprojets', ['type' => $projet->getIdCategorie()->getNom()], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{type}", name="listeprojets")
     */
    public function afficheProjets($type, ProjetRepository $repository){
        $_SESSION['role'] = "admin";
        $projets = $repository->findByJoin($type);

        return $this->render(
            'projet/projets.html.twig',
            [
                'titre' => "Liste $type",
                'projets' => $projets,
                'autorisation' => $_SESSION['role'],
                'categorie' => $type,
                'i' => 0
            ]);
    }


}
