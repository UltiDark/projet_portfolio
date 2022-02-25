<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordHasherInterface  $userPasswordHasherInterface): Response
    {
            /*route /register name app_register */
        //$this->denyAccessUnlessGranted('ROLE_ADMIN');

        $user = new Utilisateur();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            if(preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[$&+,:;=?@#|<>.^*()%!]).{12,}$/', $form->get('plainPassword')->getData()) === 0){
                $this->addFlash('error', 'Le mot de passe n\'est pas valide');
                return $this->renderForm('registration/register.html.twig', [
                    'registrationForm' => $form,
                    'titre' => 'Incription',
                ]);
            }
            // encode the plain password
            $user->setPassword(
                $userPasswordHasherInterface->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'L\'utilisateur a bien été créé !');
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

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
            'titre' => 'Incription',
        ]);
    }
}