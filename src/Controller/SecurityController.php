<?php

namespace App\Controller;

use App\Form\MdpType;
use App\Entity\Utilisateur;
use App\Form\ResetPassType;
use Symfony\Component\Mime\Email;
use App\Repository\UtilisateurRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class SecurityController extends AbstractController {
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response {
        if ($this->getUser()) {
            return $this->redirectToRoute('accueil');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername, 'error' => $error,
            'titre' => 'Connexion',
        ]);
    }

    /**
     * @Route("/oubli-mdp", name="oublimdp")
     */
    public function oubliMDP(Request $request, UtilisateurRepository $utilisateurRepository, TokenGeneratorInterface $tokenGenerator, MailerInterface $mi) {
        $form = $this->createForm(ResetPassType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //$donnees = $form->getData();
            $utilisateur = $utilisateurRepository->findOneBy(['email' =>  $form->getData()['email']]);


            if(empty($utilisateur)){
                $this->addFlash('error', 'Une erreur c\'est produite !');
                return $this->renderForm('commun/new.html.twig', [
                    'form' => $form,
                    'titre' => 'Modification de Mot de passe'
                ]);
            }

            $token = $tokenGenerator->generateToken();

            try{
                $utilisateur->setResetToken($token);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($utilisateur);
                $entityManager->flush();
            } catch (FileException $e) {
                $this->addFlash('error', 'Le mouvement a échoué !');
                return $this->redirectToRoute('accueil');
            }
            
            $url = $this->generateUrl('app_reset_password', array('token' => $token), UrlGeneratorInterface::ABSOLUTE_URL);


            $email = new Email;
            $email
                ->from('compte.pro@lopes-maxime.com')
                ->to($utilisateur->getEmail())
                ->subject('Mot de passe oublié')
                ->text(
                    "Bonjour,". PHP_EOL . PHP_EOL ."Une demande de réinitialisation de mot de passe a été effectuée pour le site https://www.lopes-maxime.com.". PHP_EOL . PHP_EOL ."Veuillez cliquer sur le lien suivant : " . $url,
                    'text/html'
                );
    
            $mi->send($email);
            $this->addFlash('success', 'Votre mail a bien été envoyé !');
            return $this->redirectToRoute('app_login');
        
        }

        return $this->renderForm('commun/new.html.twig', [
            'form' => $form,
            'titre' => 'Modification de Mot de passe'
        ]);

    }


    /**
     * @Route("/reset-pass/{token}", name="app_reset_password")
     */
    public function resetMDP(Request $request, $token, UserPasswordHasherInterface  $userPasswordHasherInterface) {

        $utilisateur = $this->getDoctrine()->getRepository(Utilisateur::class)->findOneBy(['reset_token' => $token]);

        if(empty($utilisateur)){
            $this->addFlash('error', 'L\'utilisateur n\'existe pas');
            return $this->redirectToRoute('app_login');
        }

        $form = $this->createForm(MdpType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            if ($request->isMethod('POST')) {
                $utilisateur->setResetToken(null);
                $utilisateur->setPassword($userPasswordHasherInterface->hashPassword($utilisateur, $form->get('plainPassword')->getData()));
            
                // On stocke
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($utilisateur);
                $entityManager->flush();
            
                // On crée le message flash
                $this->addFlash('success', 'Mot de passe mis à jour');
            
                // On redirige vers la page de connexion
                return $this->redirectToRoute('app_login');
        
            }
            else {
                return $this->render('commun/edit.html.twig', [
                    'utilisateur' => $utilisateur,
                    'form' => $form->createView(),
                    'titre' => $utilisateur->getPseudo(),
                    'titre2' => 'Modification du mot de passe',
                ]);
            }
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
     * @Route("/logout", name="app_logout")
     */
    public function logout() {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}