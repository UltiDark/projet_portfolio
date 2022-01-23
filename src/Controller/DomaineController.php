<?php

namespace App\Controller;

use App\Entity\Domaine;
use App\Entity\Capacite;
use App\Form\DomaineTotalType;
use App\Repository\CapaciteRepository;
use App\Repository\DomaineRepository;
use App\Repository\GroupeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/domaine")
 */
class DomaineController extends AbstractController
{
    /**
     * @Route("/liste", name="listedomaines")
     */
    public function index(DomaineRepository $domaineRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $domaines = $domaineRepository->getGroupe();
        return $this->render('domaine/index.html.twig', [
            'domaines' => $domaines,
            'titre' => 'Liste des Domaines'

        ]);
    }

    /**
     * @Route("/ajout", name="ajoutdomaine")
     */
    public function new(Request $request, CapaciteRepository $capaciteRepository, GroupeRepository $groupeRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $tab = [];
        $post = intval($request->request->get('nombre'));
        $domaine = new Domaine();
        $form = $this->createForm(DomaineTotalType::class, null, [
            'nombre' => $post,
            'domaine' => null,
            'groupes' => null,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->get('post')->getData();

            $entityManager = $this->getDoctrine()->getManager();
            for ($j = 0; $j < $post; $j++) {
                $groupe = $groupeRepository->findOneBy(['id' => $form->getExtraData()['Capacite_'.$j]['id_groupe']]);
                $tab = preg_split('/ ?[\/\?,] ?/',  $form->getExtraData()['Capacite_'.$j]['nom']);

                for ($i = 0; $i < count($tab); $i++) {
                    $capacites = $capaciteRepository->findAll();

                    $resultat = self::isExiste($capacites, $tab[$i]);

                    if (empty($resultat)) {
                        $capacite = new Capacite();
                        $capacite->setNom($tab[$i]);
                        $capacite->setIdGroupe($groupe);
                        $domaine->addIdCapacite($capacite);
                        $entityManager->persist($capacite);
                        $this->addFlash('success', 'La capacité a bien été créé !');
                    } else {
                        $capacite = $capaciteRepository->findBy(['nom' => $resultat]);
                        $domaine->addIdCapacite($capacite[0]);
                    }
                }
            }

            $domaine->setNom($form->get('Domaine')->get('nom')->getData());
            $entityManager->persist($domaine);
            $entityManager->flush();

            $this->addFlash('success', 'Le domaine a bien été créé !');


            return $this->redirectToRoute('accueil', [], Response::HTTP_SEE_OTHER);
        }
        elseif ($form->isSubmitted()){
            $this->addFlash('error', 'Une erreur c\'est produite !');
        }

        return $this->renderForm('commun/new.html.twig', [
            'domaine' => $domaine,
            'form' => $form,
            'titre' => 'Ajout d\'un nouveau domaine',
            'post' => $post,

        ]);
    }

    static function isExiste($variableA, $variableB)
    {
        foreach ($variableA as $value) {
            if ($variableB == $value->getNom()) {
                return $value->getNom();
            }
        }
        return null;
    }
    /*
    #[Route('/{id}', name: 'detaildomaine', methods: ['GET'])]
    public function show(Domaine $domaine): Response
    {
        return $this->render('domaine/show.html.twig', [
            'domaine' => $domaine,
            'titre' => 'Domaine'
        ]);
    }*/

    /**
     * @Route("/modif/{id}", name="modifdomaine")
     */
    public function edit($id, Request $request, DomaineRepository $domaineRepository, GroupeRepository $groupeRepository, CapaciteRepository $capaciteRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $domaine = $domaineRepository->getOneDomaine($id);
        $domaineEdit = $domaineRepository->findOneBy(['id' => $id]);
        $groupes =[];
        
        for($j = 0; $j < count($domaine[$id]['groupes']); $j++){
            $groupe = $groupeRepository->findOneBy(['id' => $domaine[$id]['groupes'][$j]['groupe_id']]);
            $groupes[] = $groupe;
        }

        $form = $this->createForm(DomaineTotalType::class, $domaine, [
            'nombre' => count($domaine[$id]['groupes']),
            'domaine' => $domaine[$id],
            'groupes' => $groupes,
        ]);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //$this->getDoctrine()->getManager()->flush();
            $post = $form->get('post')->getData();

            $entityManager = $this->getDoctrine()->getManager();
            for ($j = 0; $j < $post; $j++) {
                $capaciteGroupe =$form->get('Capacite_'.$j)->getData();
                $tab = preg_split('/ ?[\/\?,] ?/',  ($capaciteGroupe['nom']));

                for ($i = 0; $i < count($tab); $i++) {
                    $capacites = $capaciteRepository->findAll();

                    $resultat = self::isExiste($capacites, $tab[$i]);

                    if (empty($resultat)) {
                        $capacite = new Capacite();
                        $capacite->setNom($tab[$i]);
                        $domaineEdit->addIdCapacite($capacite);
                        $capacite->setIdGroupe($capaciteGroupe['id_groupe']);
                        $entityManager->persist($capacite);

                    } else {
                        $capacite = $capaciteRepository->findBy(['nom' => $resultat]);
                        $domaineEdit->addIdCapacite($capacite[0]);
                        $capacite[0]->setIdGroupe($capaciteGroupe['id_groupe']);
                        $entityManager->persist($capacite[0]);
                    }

                }
            }

            $domaineEdit->setNom($form->get('Domaine')->get('nom')->getData());
            $entityManager->persist($domaineEdit);
            $entityManager->flush();

            $this->addFlash('success', 'Le domaine a bien été modifié !');

            return $this->redirectToRoute('accueil', [], Response::HTTP_SEE_OTHER);
        }
        elseif ($form->isSubmitted()){
            $this->addFlash('error', 'Une erreur c\'est produite !');
 
        }

        return $this->renderForm('commun/edit.html.twig', [
            'domaine' => $domaine,
            'form' => $form,
            'titre' => 'Modification',
            'titre2' => 'Modification Domaine',
        ]);
    }

    /**
     * @Route("/sup/{id}", name="supdomaine")
     */
    public function delete(Domaine $domaine, Request $requete, DomaineRepository $domaineRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($this->isCsrfTokenValid('delete' . $domaine->getId(), $requete->query->get('csrf'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($domaine);
            $entityManager->remove($domaine);
            $entityManager->remove($domaine);
            $entityManager->flush();
            $this->addFlash('success', 'Le domaine a bien été supprimé !');

        }
        else{
            $this->addFlash('error', 'Une erreur c\'est produite !');
        }

        return $this->redirectToRoute('listedomaines', [], Response::HTTP_SEE_OTHER);
    }
}
