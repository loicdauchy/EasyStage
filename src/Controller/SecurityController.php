<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use App\Form\RegistrationEntrepriseType;
use App\Repository\AnnonceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="security_registration")
     */
    public function registration(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder){
    $user = new User();
    $form = $this->createForm(RegistrationType::class, $user);
    $form->handleRequest($request);
    if($form->isSubmitted() && $form->isValid()){
        $hash = $encoder->encodePassword($user, $user->getPassword());
        $user->setPassword($hash);
        $manager->persist($user);
        $manager->flush();
        return $this->redirectToRoute('security_login');
    }

    return $this->render('security/registration.html.twig', [
        'registrationForm' => $form->createView()
    ]);
    }

    /**
     * @Route("/", name="security_login")
     */
    public function login(AnnonceRepository $repo){
        $annonces = $repo->findAll();
        return $this->render('security/login.html.twig', [
            'annonces' => $annonces
        ]);
    }

    /**
     * @Route("/deconnexion", name="security_logout")
     */
    public function logout(){
    }

        /**
     * @Route("/newEntreprise", name="newEntreprise")
     */
    public function registrationEntreprise(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder){
        $user = new User();
        $form = $this->createForm(RegistrationEntrepriseType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $user->setRoles(["ROLE_ENTREPRISE"]);
            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute('security_login');
        }
    
        return $this->render('security/registrationEntreprise.html.twig', [
            'registrationForm' => $form->createView()
        ]);
        }

        
       
}
