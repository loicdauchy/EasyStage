<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @Route("/api", name="api_")
 */
class APIController extends AbstractController
{
    
       /**
     * @Route("/liste", name="liste", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        $articles = $userRepository->findAll();
        
        $encoders = [new JsonEncoder()];

        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);

        $jsonContent = $serializer->serialize($articles, 'json', [
            'circular_reference_handler' => function($object){
                return $object->getId();
            }
        ]);

        $response = new Response($jsonContent);

        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');

        return $response;
    }
}
