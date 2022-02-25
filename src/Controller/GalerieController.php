<?php

namespace App\Controller;

use App\Entity\Galerie;
use App\Form\GalerieType;
use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Repository\CommentaireRepository;
use Symfony\Component\Mime\Email;
use App\Repository\GalerieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
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
                $newFilename = 'img/Galerie/'.$safeFilename.'-'.uniqid().'.'.$lienFile->guessExtension();
                try {
                    $lienFile->move(
                        $this->getParameter('imgGalerie_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash('error', 'Le mouvement a échoué !');
                    return $this->redirectToRoute('accueil');
                }
                $galerie->setLien($newFilename);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($galerie);
            $entityManager->flush();

            $this->addFlash('success', 'L\'élément a bien été ajouté dans la galerie !');

            return $this->redirectToRoute('listegaleries', ['type' =>  $data->getIdCategorie()->getNom()], Response::HTTP_SEE_OTHER);
        }
        elseif($form->isSubmitted()){
            $this->addFlash('error', 'Une erreur c\'est produite !');
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
                        $this->getParameter('imgGalerie_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash('error', 'Le mouvement a échoué !');
                    return $this->redirectToRoute('accueil');
                }

                if(!empty($oldFile)){
                    $ancienFilename = $this->getParameter('imgGalerie_directory') . $oldFile;
                    $filesystem= new Filesystem();
                    $filesystem->remove($ancienFilename);
                }


                $galerie->setLien($newFilename);
            }


            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'La galerie a bien été modifié !');

            return $this->redirectToRoute('listegaleries', ['type' => $data->getIdCategorie()->getNom()], Response::HTTP_SEE_OTHER);
        }
        elseif($form->isSubmitted()){
            $this->addFlash('error', 'Une erreur c\'est produite !'); 
        }

        return $this->renderForm('commun/edit.html.twig', [
            'galerie' => $galerie,
            'form' => $form,
            'titre' => 'Modification dans la galerie',
            'titre2' => $galerie->getNom()
        ]);
    }

    /**
     * @Route("/sup/{id}", name="supgalerie")
     */
    public function delete(Request $requete, Galerie $galerie, CommentaireRepository $commentaireRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($this->isCsrfTokenValid('delete'.$galerie->getId(), $requete->query->get('csrf'))) {

            $commentaires = $commentaireRepository->findBy(['id_galerie' => $galerie->getId()]);


            $entityManager = $this->getDoctrine()->getManager();

            foreach($commentaires as $commentaire){
                $entityManager->remove($commentaire);
            }

            $oldFile = basename($galerie->getLien());


            if(!empty($oldFile)){
                $ancienFilename = $this->getParameter('imgGalerie_directory') . $oldFile;
                $filesystem= new Filesystem();
                $filesystem->remove($ancienFilename);
            }

            $entityManager->remove($galerie);
            $entityManager->flush();
            $this->addFlash('success', 'L\'élément a bien été supprimé dans la galerie !');
        }
        else{
            $this->addFlash('error', 'Le csrf n\'est pas valide !'); 
        }

    return $this->redirectToRoute('listegaleries', ['type' => $galerie->getIdCategorie()->getNom()], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{type}", name="listegaleries")
     */
    public function afficheGaleries($type, GalerieRepository $repository , Request $request, MailerInterface $mi, EntityManagerInterface $entityManager)
    {
        $galeries = $repository->findByJoin($type);
        
        if ($type == "modelisation"){
            $titre = "Modélisations 3D";
        }
        elseif($type == "sprite"){
            $titre = "Sprites 2D";
        }

        $form = $this->createForm(CommentaireType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = new Email;
            $commentaire = new Commentaire();
            $imgLien = substr($form->get('image')->getData(),1);
        
            $commentaire->setContenu($form->get('commentaire')->getData());
            $commentaire->setEmail($form->get('email')->getData());
            $galerie = $repository->findBy(['lien' => $imgLien]);
            $commentaire->setIdGalerie($galerie[0]);

            $galeries = $repository->findByJoin($type);



            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commentaire);
            $entityManager->flush();

            $email
                ->from($form->getData()['email'])
                ->to('compte.pro@lopes-maxime.com')
                ->subject('Commentaire - ' . $galerie[0]->getNom())
                ->text($form->getData()['commentaire']);
    
            $mi->send($email);
    
            $this->addFlash('success', 'Votre mail a été envoyé !');
    
        }

        return $this->render(
            'galerie/galeries.html.twig',
            [
                'titre' => $titre,
                'galeries' => $galeries,
                'form' =>$form->createView(),
                'i' => 0
            ]);
    }

}
