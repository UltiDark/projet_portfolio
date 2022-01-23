<?php

namespace App\Controller;

use App\Entity\Intro;
use App\Form\IntroType;
use App\Repository\IntroRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/intro")
 */
class IntroController extends AbstractController
{
    /**
     * @Route("/liste", name="listeintros")
     */
    public function index(IntroRepository $introRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('intro/index.html.twig', [
            'intros' => $introRepository->getByOrder(),
            'titre' => 'Liste des informations de la intro',

        ]);
    }

    /**
     * @Route("/ajout", name="ajoutintro")
     */
    public function new(Request $request, IntroRepository $introRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $intro = new Intro();
        $form = $this->createForm(IntroType::class, $intro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $place = intval($form->get('place')->getData());

            if(empty($form->get('place')->getData()) && $form->get('place')->getData() != 0){
                $introLast = $introRepository->getLast();
                if(empty($introLast[0])){
                    $intro->setPlace(0);
                }
                else{
                    $intro->setPlace(strval($introLast[0]->getPlace())+1);
                }
            }
            else{
                $intros = $introRepository->getFrom($place);
                foreach($intros as $introListe){
                    $introListe->setPlace(strval($introListe->getPlace()+1));
                }
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($intro);
            $entityManager->flush();

            $this->addFlash('success', 'Le paragraphe a bien été créé !');

            return $this->redirectToRoute('accueil', [], Response::HTTP_SEE_OTHER);
        }
        elseif ($form->isSubmitted()){
            $this->addFlash('error', 'Une erreur c\'est produite !');
        }

        return $this->renderForm('commun/new.html.twig', [
            'intro' => $intro,
            'form' => $form,
            'titre' => 'Ajout dans l\'intro'
        ]);
    }

    /*
    #[Route('/{id}', name: 'intro_show', methods: ['GET'])]
    public function show(Intro $intro): Response
    {
        return $this->render('intro/show.html.twig', [
            'intro' => $intro,
        ]);
    }*/

    /**
     * @Route("/modif/{id}", name="modifintro")
     */
    public function edit(Request $request, Intro $intro, IntroRepository $introRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $place = strval($intro->getPlace());

        $form = $this->createForm(IntroType::class, $intro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $introPlace = $introRepository->findBy(['place' => strval( $form->get('place')->getData() ) ]);
            if(!empty($introPlace[0])){
                $introPlace[0]->setPlace($place);
            }
            
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Le paragraphe de l\'intro a bien été modifié !');

            return $this->redirectToRoute('accueil', [], Response::HTTP_SEE_OTHER);
        }
        elseif ($form->isSubmitted()){
            $this->addFlash('error', 'Une erreur c\'est produite !');
 
        }

        return $this->renderForm('commun/edit.html.twig', [
            'intro' => $intro,
            'form' => $form,
            'titre' => 'Modification',
            'titre2' => 'Modification Intro',
        ]);
    }

    /**
     * @Route("/sup/{id}", name="supintro")
     */
    public function delete(Request $requete, Intro $intro, IntroRepository $introRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($this->isCsrfTokenValid('delete'.$intro->getId(), $requete->query->get('csrf'))) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($intro);
            $entityManager->flush();

            $intros = $introRepository->getByOrder();
            for($i = 0; $i < count($intros); $i++){
                $intros[$i]->setPlace($i);
            }

            $entityManager->flush();
            $this->addFlash('success', 'Le paragraphe a bien été supprimé !');
        }
        else{
            $this->addFlash('error', 'Une erreur c\'est produite !');
        }

        return $this->redirectToRoute('listeintros', [], Response::HTTP_SEE_OTHER);
    }
}
