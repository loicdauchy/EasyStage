<?php

namespace App\Controller;

use App\Entity\Candidature;
use App\Entity\User;
use App\Entity\Competence;
use App\Entity\Entreprise;
use App\Form\CandidatureType;
use App\Form\InfoUserType;
use App\Form\CompetenceType;
use App\Form\EntrepriseType;
use App\Form\UsersCompetenceType;
use App\Repository\CandidatureRepository;
use App\Repository\EntrepriseRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
/**
* @Route("/users", name="users_")
*/
class UsersController extends AbstractController
{
    
    /**
     * Information user
     * @Route("/infos/{id}", name="infoUser")
     */
    public function infosUser(Request $request, EntityManagerInterface $manager, User $user): Response
    {
        $form = $this->createForm(InfoUserType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($user);
            $manager->flush();
        }
        return $this->render('users/index.html.twig', [
            'infoForm' => $form->createView()
        ]);
    }

    /**
     * Ajout de nouvel compétences
     * @Route("/newSkill/{id}", name="skill")
     */
    public function newCompetences(Request $request, EntityManagerInterface $manager, User $user){
        $form = $this->createForm(UsersCompetenceType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){         
            $manager->persist($user);
            $manager->flush();
            return $this->redirect($request->getUri());
        }

        $competence = new Competence();
        $formC = $this->createForm(CompetenceType::class, $competence);
        $formC->handleRequest($request);
        if($formC->isSubmitted() && $formC->isValid()){
            $manager->persist($competence);
            $manager->flush();
            return $this->redirect($request->getUri());
        }
        return $this->render('users/addSkill.html.twig', [
            'compForm' => $form->createView(),
            'addComp' => $formC->createView()
        ]);
    }

    /**
     * @Route("/entreprise", name="entreprise")
     */
    public function entreprise(Request $request, EntityManagerInterface $manager, EntrepriseRepository $repo){
        $entreprise = new Entreprise();
        $form = $this->createForm(EntrepriseType::class, $entreprise);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($entreprise);
            $manager->flush();
            return $this->redirect($request->getUri());
        }


        return $this->render('users/entreprise.html.twig', [
            'entrepriseForm' => $form->createView(),
            'entreprises' => $repo->findAll()
        ]);
    }

    /**
     * @Route("/detailEntreprise/{id}", name="detailEntreprise")
     */
    public function detailEntreprise(EntrepriseRepository $repo, Entreprise $entreprise){
        $entreprise->getId();
        return $this->render('users/detailEntreprise.html.twig', [
            'detailEntreprise' => $repo->find($entreprise)
        ]);
    }

    /**
     * @Route("/candidature", name="candidature")
     */
    public function candidature(Request $request, EntityManagerInterface $manager, CandidatureRepository $repo){
        $candidature = new Candidature();
        $form = $this->createForm(CandidatureType::class, $candidature);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $user = $this->getUser();
            $candidature->setApprenant($user);
            $manager->persist($candidature);
            $manager->flush();
            return $this->redirect($request->getUri());
        }
        $user = $this->getUser();
        $id = $user->getId();
        return $this->render('users/candidature.html.twig', [
            'candidatureForm' => $form->createView(),
            'candidatures' => $repo->findByExampleField($id)
        ]);   
    }

    /**
     * @Route("/upCandidature/{id}", name="upCandidature")
     */
    public function upCandidature(Request $request, EntityManagerInterface $manager, Candidature $candidature){
        $form = $this->createForm(CandidatureType::class, $candidature);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){         
            $manager->persist($candidature);
            $manager->flush();
            return $this->redirectToRoute('users_candidature');
        }

        return $this->render('users/upCandidature.html.twig', [
            'upCandidatureForm' => $form->createView()
        ]);
    }
}
