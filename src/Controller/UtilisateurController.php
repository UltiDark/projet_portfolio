<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\ForgottenType;
use App\Form\UtilisateurType;
use App\Form\RegistrationFormType;
use App\Repository\BanqueImageRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @Route("/utilisateur")
 */
class UtilisateurController extends AbstractController
{
    /**
     * @Route("/liste", name="listeutilisateurs")
     */
    public function index(UtilisateurRepository $utilisateurRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('utilisateur/index.html.twig', [
            'utilisateurs' => $utilisateurRepository->findAll(),
            'titre' => 'Liste Utilisateur'
        ]);
    }

    /**
     * @Route("/ajout", name="ajoututilisateur")
     */
    public function new(Request $request, UserPasswordHasherInterface  $userPasswordHasherInterface): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $utilisateur = new Utilisateur();
        $form = $this->createForm(RegistrationFormType::class, $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /*if(preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[$&+,:;=?@#|<>.^*()%!]).{12,}$/', $form->get('plainPassword')->getData()) === 0){
                $this->addFlash('error', 'Le mot de passe n\'est pas valide');
                return $this->renderForm('commun/new.html.twig', [
                    'utilisateur' => $utilisateur,
                    'form' => $form,
                    'titre' => 'Nouvel Utilisateur',
                ]);
            }*/

            $utilisateur->setPassword(
                $userPasswordHasherInterface->hashPassword(
                    $utilisateur,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($utilisateur);
            $entityManager->flush();
            $this->addFlash('success', 'Un nouvel utilisateur a bien été ajouté !');
            return $this->redirectToRoute('accueil');
        }
        elseif($form->isSubmitted()){
            if(preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[$&+,:;=?@#|<>.^*()%!]).{12,}$/', $form->get('plainPassword')->getData()) === 0){
                $this->addFlash('error', 'Le mot de passe n\'est pas valide');
            }
            else{
                $this->addFlash('error', 'Une erreur c\'est produite !');
            }
        }

        return $this->renderForm('commun/new.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form,
            'titre' => 'Nouvel Utilisateur'

        ]);
    }

    /**
     * @Route("/details/{id}", name="detailsutilisateur")
     */

    public function show(Utilisateur $utilisateur, BanqueImageRepository $banqueImageRepository): Response
    {

        if($this->IsGranted('ROLE_ADMIN') || $utilisateur->getId() != $this->getUser()->getId()){
            $this->addFlash('error', 'Vous n\'avez pas accès');
            return $this->redirectToRoute('accueil');
        }
        
        return $this->render('utilisateur/show.html.twig', [
            'utilisateur' => $utilisateur,
            'titre' => $utilisateur->getPseudo(),
            'projets' => $banqueImageRepository->findAllLogo($utilisateur->getId()),
        ]);

    }

    /**
     * @Route("/password/{id}", name="passwordutilisateur")
     */
    public function passwordU(Utilisateur $utilisateur, BanqueImageRepository $banqueImageRepository, Request $request, UserPasswordHasherInterface  $userPasswordHasherInterface): Response
    {

        if( $utilisateur->getId() != $this->getUser()->getId() || !$this->IsGranted('ROLE_ADMIN')){
            $this->addFlash('error', 'Vous n\'avez pas accès');
            return $this->redirectToRoute('accueil');
        }


        $form = $this->createForm(ForgottenType::class, $utilisateur, ['email' => $utilisateur->getEmail()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if(password_verify($form->get('ancien')->getData(), $utilisateur->getPassword())) {

                if(preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[$&+,:;=?@#|<>.^*()%!]).{12,}$/', $form->get('plainPassword')->getData()) === 0){
                    $this->addFlash('error', 'Le mot de passe n\'est pas valide');
                    return $this->renderForm('commun/new.html.twig', [
                        'utilisateur' => $utilisateur,
                        'form' => $form,
                        'titre' => 'Modification MDP',
                    ]);
                }

                $utilisateur->setPassword(
                    $userPasswordHasherInterface->hashPassword(
                        $utilisateur,
                        $form->get('plainPassword')->getData()
                    )
                );
            }
            else {
                $this->addFlash('error', 'Le mot de passe est incorrecte!');
                return $this->render('utilisateur/show.html.twig', [
                    'utilisateur' => $utilisateur,
                    'titre' => $utilisateur->getPseudo(),
                    'projets' => $banqueImageRepository->findAllLogo($utilisateur->getId()),
                ]);
            }

            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'L\'utilisateur a bien été modifié !');
            return $this->redirectToRoute('accueil');
        }
        elseif($form->isSubmitted()){
            $this->addFlash('error', 'Une erreur c\'est produite !');
        }


        return $this->render('commun/edit.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form->createView(),
            'titre' => $utilisateur->getPseudo(),
            'titre2' => 'Modification du mot de passe',
        ]);

    }


    /**
     * @Route("/modif/{id}", name="modifutilisateur")
     */
    public function edit(Request $request, Utilisateur $utilisateur, SluggerInterface $slugger, UserInterface $user): Response
    {
        if($this->IsGranted('ROLE_ADMIN') || $utilisateur->getId() == $this->getUser()->getId()){

            $oldFile = basename($utilisateur->getPhoto());

            $form = $this->createForm(UtilisateurType::class, $utilisateur, ['roles' => $utilisateur->getRoles()]);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $lienFile = $form->get('photo')->getData();
                if (!empty($lienFile)) {
                    $originalFilename = pathinfo($lienFile->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = 'img/Utilisateur/'.$safeFilename.'-'.uniqid().'.'.$lienFile->guessExtension();

                    try {
                        $lienFile->move(
                            $this->getParameter('imgUtilisateur_directory'),
                            $newFilename
                        );
                    } catch (FileException $e) {
                        // ... handle exception if something happens during file upload
                    }

                    if(!empty($oldFile)){
                        $ancienFilename = $this->getParameter('imgFrise_directory') . $oldFile;
                        $filesystem= new Filesystem();
                        $filesystem->remove($ancienFilename);
                    }

                    $utilisateur->setPhoto($newFilename);
                }

                $this->getDoctrine()->getManager()->flush();
                $this->addFlash('success', 'L\'utilisateur a bien été modifié !');
                return $this->redirectToRoute('accueil');
            }
            elseif($form->isSubmitted()){
                $this->addFlash('error', 'Une erreur c\'est produite !');
            }
        }
        else{
            $this->addFlash('error', 'Vous n\'avez pas accès');
            return $this->redirectToRoute('accueil');
        }

        return $this->renderForm('commun/edit.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form,
            'titre' => $utilisateur->getNom(),
            'titre2' => 'Modifier ' . $utilisateur->getNom() .' '. $utilisateur->getPrenom() ,
        ]);
    }

    /**
     * @Route("/sup/{id}", name="suputilisateur")
     */
    public function delete(Request $request, Utilisateur $utilisateur): Response
    {
        if($this->IsGranted('ROLE_ADMIN') || $utilisateur->getId() == $this->getUser()->getId){
        
            if ($this->isCsrfTokenValid('delete'.$utilisateur->getId(), $request->query->get('csrf'))) {
                $entityManager = $this->getDoctrine()->getManager();
                $oldFile = basename($utilisateur->getPhoto());

                if(!empty($oldFile)){
                    $ancienFilename = $this->getParameter('imgUtilisateur_directory') . $oldFile;
                    $filesystem= new Filesystem();
                    $filesystem->remove($ancienFilename);
                }
                $entityManager->remove($utilisateur);
                $entityManager->flush();
                $this->addFlash('success', 'L\'utilisateur a bien été supprimé !');
            }
            else{
                $this->addFlash('error', 'Une erreur c\'est produite !');
            }
        }
        else{
            $this->addFlash('error', 'Vous n\'avez pas accès');
            return $this->redirectToRoute('accueil');
        }

        return $this->redirectToRoute('dashboard', [], Response::HTTP_SEE_OTHER);
    }
}
