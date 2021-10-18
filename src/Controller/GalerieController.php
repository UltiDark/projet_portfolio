<?php

namespace App\Controller;

use App\Entity\Galerie;
use App\Form\GalerieType;
use App\Repository\GalerieRepository;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

/**
 * @Route("/galeries")
 */
class GalerieController extends AbstractController
{

    /**
     * @Route("/ajout", name="ajoutgalerie")
     */
    public function ajoutGalerie(Request $request, SluggerInterface $slugger): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $galerie = new Galerie();
        $form = $this->createForm(GalerieType::class, $galerie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $lienFile = $form->get('lien')->getData();
            if (!empty($lienFile)) {
                $originalFilename = pathinfo($lienFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = 'img/Frise/'.$safeFilename.'-'.uniqid().'.'.$lienFile->guessExtension();
                try {
                    $lienFile->move(
                        $this->getParameter('imgGalerie_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $galerie->setLien($newFilename);
            }

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
    public function edit(Request $request, Galerie $galerie, SluggerInterface $slugger): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $oldFile = basename($galerie->getLien());

        $form = $this->createForm(GalerieType::class, $galerie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $lienFile = $form->get('lien')->getData();
            if (!empty($lienFile)) {
                $originalFilename = pathinfo($lienFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = 'img/Galerie/'.$safeFilename.'-'.uniqid().'.'.$lienFile->guessExtension();

                try {
                    $lienFile->move(
                        $this->getParameter('imgLogo_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                if(!empty($oldFile)){
                    $ancienFilename = $this->getParameter('imgLogo_directory') . $oldFile;
                    $filesystem= new Filesystem();
                    $filesystem->remove($ancienFilename);
                }


                $galerie->setLien($newFilename);
            }


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
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

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
                'i' => 0
            ]);
    }

}
