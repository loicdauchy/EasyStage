<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Annonce;
use App\Form\AnnonceType;
use App\Form\SearchStagiaireType;
use App\Repository\UserRepository;
use App\Repository\CandidatureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/entreprise", name="entreprise_")
 */
class EntrepriseController extends AbstractController
{
    
    /**
     * @Route("/stagiaires", name="stagiaires")
     */
    public function index(UserRepository $repo, Request $request): Response
    {
        $stagiaireFind = [];
        $form = $this->createForm(SearchStagiaireType::class);
        if($form->handleRequest($request)->isSubmitted() && $form->isValid()){
            $critere = $form->getData();
            $stagiaireFind = $repo->searchStagiaire($critere);
        }
        return $this->render('entreprise/index.html.twig', [
            'stagiaires' => $repo->findStagiaire(),
            'searchForm' => $form->createView(),
            'stagiaireFind' => $stagiaireFind,
        ]);
    }

    /**
     * @Route("/stagiaires/{id}", name="infoStagiaire")
     */
    public function infoS(User $user,  CandidatureRepository $repo){
        $id = $user->getId();
        return $this->render('entreprise/infoS.html.twig', [
            'user' => $user,
            'candidatures' => $repo->findByExampleField($id)
        ]);
    }

    /**
     * @Route("/annoncePost/{id}", name="newAnnonce")
     */
    public function newAnnonce(Request $request, EntityManagerInterface $manager, User $user){
        $annonce = new Annonce();
        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $annonce->setEntreprise($user);
            $manager->persist($annonce);
            $manager->flush();
            return $this->redirect($request->getUri());
        }

        return $this->render('entreprise/newAnnonce.html.twig', [
            'annonceForm' => $form->createView()
        ]);
    }
}
