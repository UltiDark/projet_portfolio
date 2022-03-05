<?php

namespace App\Controller;

use App\Entity\BanqueImage;
use App\Entity\Projet;
use App\Form\ProjetType;
use App\Repository\BanqueImageRepository;
use App\Repository\ProjetRepository;
use App\Repository\CategorieRepository;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

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
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $projet = new Projet();

        $categorie = $categorieRepository->findOneBy(['nom'=>$type]);

        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lienFiles = $form->get('images')->getData();
            $logoFiles = $form->get('logo')->getData();
            $buildFiles = $form->get('build')->getData();
            $docFiles = $form->get('document')->getData();

            $nom = str_replace(' ', '-', $form->get('nom')->getData());

            //$data = $form->getData();
            $projet->setIdCategorie($categorie);


            if ($buildFiles) {
                $newFilename = 'img/Projet/'.$nom.'/build'.'-'.uniqid().'.'.$buildFiles->guessExtension();
                self::addFiles($newFilename,$buildFiles, $nom, $this);
                $projet->setBuild($newFilename);
            }

            if ($docFiles) {
                $newFilename = 'img/Projet/'.$nom.'/doc'.'-'.uniqid().'.'.$docFiles->guessExtension();
                self::addFiles($newFilename,$docFiles, $nom, $this);
                $projet->setDocument($newFilename);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($projet);
            $entityManager->flush();

            if ($logoFiles) {
                $newFilename = 'img/Projet/'.$nom.'/logo'.'-'.uniqid().'.'.$logoFiles->guessExtension();
                self::addFiles($newFilename,$logoFiles, $nom, $this);
                $image = new BanqueImage();
                $image->setNom('logo');
                $image->setLien($newFilename);
                $image->setIdProjet($projet);
                $entityManager->persist($image);
                $entityManager->flush();
            }

            if ($lienFiles) {
                $i = 0;
                foreach($lienFiles as $lienFile){
                    $newFilename = 'img/Projet/'.$nom.'/screen'.$i.'-'.uniqid().'.'.$lienFile->guessExtension();
                    self::addFiles($newFilename,$lienFile, $nom, $this);
                    $image = new BanqueImage();
                    $image->setNom('screen');
                    $image->setLien($newFilename);
                    $image->setIdProjet($projet);
                    $entityManager->persist($image);
                    $i++;
                }
                $entityManager->flush();
            }

            $this->addFlash('success', 'L\'élément a bien été ajouté aux projets !');
            return $this->redirectToRoute('listeprojets', ['type' =>  $type], Response::HTTP_SEE_OTHER);
        }
        elseif($form->isSubmitted()){
            $this->addFlash('error', 'Une erreur c\'est produite !');
        }

        return $this->renderForm('commun/new.html.twig', [
            'projet' => $projet,
            'form' => $form,
            'titre' => "Ajout $type",

        ]);
    }

    /**
     * @Route("/details/{id}", name="detailprojet")
     */
    public function show(Projet $projet, BanqueImageRepository $banquerepository): Response
    {
        $images = $banquerepository->findByLimit($projet->getId());
        $logo = $banquerepository->findLogo($projet->getId());

        if ($images == null){
            $this->addFlash('error', 'Pas assez d\'image');
            return $this->redirectToRoute('accueil');
        }

        return $this->render('projet/show.html.twig', [
            'titre' => $projet->getNom(),
            'utilisateurs' => $projet->getIdUtilisateur(),
            'projet' => $projet,
            'images' => $images,
            'logo' => $logo,
        ]);
    }

    /**
     * @Route("/modif/{id}", name="modifprojet")
     */
    public function edit(Request $request, Projet $projet, SluggerInterface $slugger, BanqueImageRepository $banqueImageRepository): Response
    {

        foreach($projet->getIdUtilisateur() as $user){
            if($this->getUser()->getEmail() != $user->getEmail()){
                $acces = false;
            }
            else{
                $acces = true;
                break;
            }
        }

        if(!$this->isGranted('ROLE_ADMIN') && $acces == false){
            $this->addFlash('error', 'L\'utilisateur n\'a pas accès');
            return $this->redirectToRoute('app_login');
        }

        $logo = $banqueImageRepository->findBy(['nom' => 'logo']);
        $build = $projet->getBuild();
        $doc = $projet->getDocument();

        $oldLogo = basename($logo[0]->getLien());
        $oldBuild = basename($build);
        $oldDoc = basename($doc);

        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $lienFiles = $form->get('images')->getData();
            $logoFiles = $form->get('logo')->getData();
            $buildFiles = $form->get('build')->getData();
            $docFiles = $form->get('document')->getData();

            $nom = str_replace(' ', '-', $form->get('nom')->getData());

            if (!empty($buildFiles)) {
                $newFilename = 'img/Projet/'.$nom.'/build'.'-'.uniqid().'.'.$buildFiles->guessExtension();
                self::addFiles($newFilename,$buildFiles, $nom, $this);
                self::removeFiles($oldBuild, $nom, $this);
                $projet->setBuild($newFilename);
            }

            if (!empty($docFiles)) {
                $newFilename = 'img/Projet/'.$nom.'/doc'.'-'.uniqid().'.'.$docFiles->guessExtension();
                self::addFiles($newFilename,$docFiles, $nom, $this);

                self::removeFiles($oldDoc, $nom, $this);
                $projet->setDocument($newFilename);
            }

            if (!empty($logoFiles)) {
                $newFilename = 'img/Projet/'.$nom.'/logo'.'-'.uniqid().'.'.$logoFiles->guessExtension();
                self::addFiles($newFilename,$logoFiles, $nom, $this);

                if(!empty($oldLogo)){
                    self::removeFiles($oldLogo, $nom, $this);
                    $this->getDoctrine()->getManager()->remove($logo[0]);
                }
                
                $image = new BanqueImage();
                $image->setNom('logo');
                $image->setLien($newFilename);
                $image->setIdProjet($projet);
                $this->getDoctrine()->getManager()->persist($image);
            }

            if (!empty($lienFiles)) {
                $i = 0;
                foreach($lienFiles as $lienFile){
                    $newFilename = 'img/Projet/'.$nom.'/screen'.$i.'-'.uniqid().'.'.$lienFile->guessExtension();
                    self::addFiles($newFilename,$lienFile, $nom, $this);

                    $image = new BanqueImage();
                    $image->setNom('screen');
                    $image->setLien($newFilename);
                    $image->setIdProjet($projet);
                    $this->getDoctrine()->getManager()->persist($image);
                    $i++;
                }
            }

            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Le projet a bien été modifié !');

            return $this->redirectToRoute('listeprojets', ['type' => $data->getIdCategorie()->getNom()], Response::HTTP_SEE_OTHER);
        }
        elseif($form->isSubmitted()){
            $this->addFlash('error', 'Une erreur c\'est produite !');
        }

        return $this->renderForm('commun/edit.html.twig', [
            'projet' => $projet,
            'form' => $form,
            'titre' => $projet->getNom(),
            'titre2' => "Modification ".$projet->getNom(),
        ]);
    }

    /**
     * @Route("/sup/{id}", name="supprojet")
     */
    public function delete(Request $requete, Projet $projet, BanqueImageRepository $banquerepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($this->isCsrfTokenValid('delete'.$projet->getId(), $requete->query->get('csrf'))) {
            $images = $banquerepository->findBy(['id_projet' => $projet->getId()]);
            $entityManager = $this->getDoctrine()->getManager();
            $nom = str_replace(' ', '-', $projet->getNom());

            self::removeFiles($projet->getDocument(), $nom, $this);
            self::removeFiles($projet->getBuild(), $nom, $this);

            foreach($images as $image){
                self::removeFiles($image->getLien(), $nom, $this);
                $entityManager->remove($image);
            }
            $entityManager->remove($projet);
            $entityManager->flush();
            $this->addFlash('success', 'L\'élément a bien été supprimé aux projets !');

        }
        else{
            $this->addFlash('error', 'Le csrf n\'est pas valide!');
        }

        return $this->redirectToRoute('listeprojets', ['type' => $projet->getIdCategorie()->getNom()], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{type}", name="listeprojets")
     */
    public function afficheProjets($type, ProjetRepository $repository){
        $projets = $repository->findByJoin($type);

        /*foreach ($projets as $value){
            dd($value[0]->getIdUtilisateur()[0]->getEmail());
            foreach($value[0]->getIdUtilisateur() as $user){
                dd($user->getEmail());
            }
        }*/

        return $this->render(
            'projet/projets.html.twig',
            [
                'titre' => "Liste $type",
                'projets' => $projets,
                'categorie' => $type,
                'i' => 0,
                'j' => 0
            ]);
    }


    static function removeFiles($basename, $nomProjet,$projetParam){
        if(!empty($basename)){
            $ancienFilename = $projetParam->getParameter('imgProjet_directory').$nomProjet .'/'. basename($basename);
            $filesystem= new Filesystem();
            $filesystem->remove($ancienFilename);
        }
    }

    static function addFiles($newFilename,$basename, $nomProjet,$projetParam){

        // 
        try {
            $basename->move(
                $projetParam->getParameter('imgProjet_directory').'/'.$nomProjet,
                $newFilename
            );
        } catch (FileException $e) {
            $projetParam->addFlash('error', 'Le mouvement a échoué !');
            return $projetParam->redirectToRoute('accueil');
        }
    }
}
