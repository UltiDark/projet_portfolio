<?php

namespace App\Controller;

use App\Entity\Frise;
use App\Form\FriseType;
use App\Repository\FriseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

/**
 * @Route("/frise")
 */
class FriseController extends AbstractController
{
    /**
     * @Route("/liste", name="listefrise")
     */
    public function index(FriseRepository $friseRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $date = time();

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
    public function new(Request $request, SluggerInterface $slugger): Response
    {
        // création d'une nouvelle entité
        $frise = new Frise();
        // création du formulaire lié à la frise
        $form = $this->createForm(FriseType::class, $frise);
        $form->handleRequest($request);

        // si le formulaire est conforme
        if ($form->isSubmitted() && $form->isValid()) {
            $lienFile = $form->get('lien')->getData();
            if (!empty($lienFile)) {
                $originalFilename = pathinfo($lienFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = 'img/Frise/'.$safeFilename.'-'.uniqid().'.'.$lienFile->guessExtension();
                try {
                    $lienFile->move(
                        $this->getParameter('imgFrise_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash('error', 'Le mouvement a échoué !');
                    return $this->redirectToRoute('accueil');
                }
                $frise->setLien($newFilename);
            }
            $entityManager = $this->getDoctrine()->getManager();
            // mise en place de la requête indiquant que la donnée selectionnée doit être ajouté
            $entityManager->persist($frise);
            // exécution de la requête de "insert"
            $entityManager->flush();
            $this->addFlash('success', 'Un élément a bien été ajouté dans la liste !');

            // Retour liste frise
            return $this->redirectToRoute('listefrise', [], Response::HTTP_SEE_OTHER);
        }
        elseif($form->isSubmitted()){
            $this->addFlash('error', 'Une erreur c\'est produite !');
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
    public function edit(Request $request, Frise $frise, SluggerInterface $slugger): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $oldFile = basename($frise->getLien());
        // création du formulaire lié à la frise
        $form = $this->createForm(FriseType::class, $frise);

        $form->handleRequest($request);

        // si le formulaire est conforme
        if ($form->isSubmitted() && $form->isValid()) {
            // mise en place et execusion de la requete de "update"
            $lienFile = $form->get('lien')->getData();
            if (!empty($lienFile)) {
                $originalFilename = pathinfo($lienFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = 'img/Frise/'.$safeFilename.'-'.uniqid().'.'.$lienFile->guessExtension();

                try {
                    $lienFile->move(
                        $this->getParameter('imgFrise_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash('error', 'Le mouvement a échoué !');
                    return $this->redirectToRoute('accueil');
                }

                if(!empty($oldFile)){
                    $ancienFilename = $this->getParameter('imgFrise_directory') . $oldFile;
                    $filesystem= new Filesystem();
                    $filesystem->remove($ancienFilename);
                }

                $frise->setLien($newFilename);
            }
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'La frise a bien été modifié !');

            // Retour liste frise
            return $this->redirectToRoute('listefrise', [], Response::HTTP_SEE_OTHER);
        }
        elseif($form->isSubmitted()){
            $this->addFlash('error', 'Une erreur c\'est produite !');
        }

        // affichage du formulaire
        return $this->renderForm('commun/edit.html.twig', [
            'frise' => $frise,
            'form' => $form,
            'titre' => 'Modification',
            'titre2' => 'Modification Frise',
        ]);
    }

    /**
     * @Route("/sup/{id}", name="supfrise")
     */
    public function delete(Request $requete, Frise $frise): Response
    {
        // Autorise L'Admin
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // si le token CRSF et present et conforme
        if ($this->isCsrfTokenValid('delete'.$frise->getId(), $requete->query->get('csrf'))) {
            $entityManager = $this->getDoctrine()->getManager();

            $oldFile = basename($frise->getLien());


            if(!empty($oldFile)){
                $ancienFilename = $this->getParameter('imgFrise_directory') . $oldFile;
                $filesystem= new Filesystem();
                $filesystem->remove($ancienFilename);
            }
            // mise en place de la requête indiquant que la donnée selectionnée doit être supprimée
            $entityManager->remove($frise);
            // exécution de la requête de "delete"
            $entityManager->flush();
            $this->addFlash('success', 'L\'élément a bien été modifié de la frise !');
        }
        else{
            $this->addFlash('error', 'Une erreur c\'est produite !');
        }

        // Retour liste frise
        return $this->redirectToRoute('listefrise', [], Response::HTTP_SEE_OTHER);
    }
}
