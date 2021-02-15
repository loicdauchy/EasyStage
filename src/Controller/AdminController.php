<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Annonce;
use App\Entity\Promotion;
use App\Entity\Competence;
use App\Entity\Entreprise;
use App\Form\AnnonceAdminType;
use App\Form\EditeUserType;
use App\Form\PromotionType;
use App\Form\CompetenceType;
use App\Form\EntrepriseType;
use App\Form\SearchEntrepriseType;
use App\Repository\UserRepository;
use App\Repository\AnnonceRepository;
use App\Repository\PromotionRepository;
use App\Repository\EntrepriseRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CandidatureRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
/**
 * @Route("/admin", name="admin_")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(Request $request, EntityManagerInterface $manager): Response
    {
        $competence = new Competence();
        $formC = $this->createForm(CompetenceType::class, $competence);
        $formC->handleRequest($request);
        if($formC->isSubmitted() && $formC->isValid()){
            $manager->persist($competence);
            $manager->flush();
            return $this->redirectToRoute('admin_index');
        }
        return $this->render('admin/index.html.twig', [
            'compForm' => $formC->createView()
        ]);
    }

    /**
     * Liste des utilisateurs
     * @Route("/users", name="users")
     */
    public function userList(UserRepository $users){       
        return $this->render("admin/users.html.twig", [
            'users' => $users->findAll()
        ]);
    }

    /**
     * Supprimer un utilisateur
     * @Route("/deleteU/{id}", name="deleteU")
     */
    public function deleteU(EntityManagerInterface $manager, User $user): Response
    {
        $manager->remove($user);
        $manager->flush();
        return $this->redirectToRoute('admin_users');
    }

    /**
     * @Route("/editeU/{id}", name="editeU")
     * 
     */
    public function updateU(Request $request, EntityManagerInterface $manager, User $user,  CandidatureRepository $repo): Response
    {
        $form = $this->createForm(EditeUserType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($user);
            $manager->flush();
            return $this->redirect($request->getUri());
        }

        $id = $user->getId();
        return $this->render('admin/edite.html.twig', [
            'user' => $user,
            'upForm' => $form->createView(),
            'candidatures' => $repo->findByExampleField($id)
        ]);
    }

    /**
     * @Route("/infoU/{id}", name="infoU")
     */
    public function infoU(User $user,  CandidatureRepository $repo){
        $id = $user->getId();
        return $this->render('admin/infoU.html.twig', [
            'user' => $user,
            'candidatures' => $repo->findByExampleField($id)
        ]);
    }

    /**
     * @Route("/entreprises", name="entreprises")
     */
    public function entreprise(EntrepriseRepository $repo, Request $request, EntrepriseRepository $entrepriseRepo){

        $entrepriseFind = [];
        $form = $this->createForm(SearchEntrepriseType::class);
        if($form->handleRequest($request)->isSubmitted() && $form->isValid()){
            $critere = $form->getData();
            $entrepriseFind = $entrepriseRepo->findEntreprise($critere);
        }
        return $this->render('admin/entreprise.html.twig', [
            'entreprises' => $repo->findAll(),
            'searchForm' => $form->createView(),
            'entrepriseFind' => $entrepriseFind
        ]);
    }

    /**
     * @Route("/upEntreprise/{id}", name="upEntreprises")
     */
    public function upEntreprise(Request $request, EntityManagerInterface $manager, Entreprise $entreprise){
        $form = $this->createForm(EntrepriseType::class, $entreprise);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($entreprise);
            $manager->flush();
            return $this->redirectToRoute('admin_entreprises');
        }

        return $this->render('admin/upEntreprise.html.twig', [
            'upEntrepriseForm' => $form->createView(),
            'entreprise' => $entreprise
        ]);
    }

    /**
     * Supprimer une entreprise
     * @Route("/deleteE/{id}", name="deleteE")
     */
    public function deleteE(EntityManagerInterface $manager, Entreprise $entreprise): Response
    {
        $manager->remove($entreprise);
        $manager->flush();
        return $this->redirectToRoute('admin_entreprises');
    }

    /**
     * @Route("/promotions", name="promotions")
     */
    public function promotions(PromotionRepository $repo, Request $request, EntityManagerInterface $manager){
        $promotion = new Promotion();

        $form = $this->createForm(PromotionType::class, $promotion);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($promotion);
            $manager->flush();
            return $this->redirect($request->getUri());
        }
        return $this->render('admin/promotions.html.twig', [
            'promotions' => $repo->findAll(),
            'promoForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/promotion/{id}", name="detailPromo")
     */
    public function detailPromotion(UserRepository $repo, Promotion $promotion){
        $id = $promotion->getId();
        return $this->render('admin/detailPromotion.html.twig', [
            'apprenants' => $repo->findByExampleField($id),
            'promo' => $promotion
        ]);
    }

    /**
     * @Route("/annonces", name="annonces")
     */
    public function annonces(AnnonceRepository $repo){
        return $this->render('admin/annonces.html.twig', [
            'annonces' => $repo->findAll()
        ]);
    }

    /**
     * @Route("/annonce/{id}", name="annonce")
     */
    public function adminAnnonces(Request $request, EntityManagerInterface $manager, Annonce $annonce){
        $form = $this->createForm(AnnonceAdminType::class, $annonce);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($annonce);
            $manager->flush();
            return $this->redirectToRoute('admin_annonces');
        }
        return $this->render('admin/adminAnnonces.html.twig', [
            'annonceForm' => $form->createView(),
            'annonce' => $annonce
        ]);
    }
}
