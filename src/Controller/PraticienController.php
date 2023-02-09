<?php

namespace App\Controller;

use App\Entity\Praticien;
use App\Repository\PatientRepository;
use App\Repository\PraticienRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class PraticienController extends AbstractController
{

    //Route pour obtenir liste de TOUS les praticien
    #[Route('/api/praticiens', name: 'praticient', methods: ['GET'])]
    public function getPraticienList(PraticienRepository $praticienRepository, SerializerInterface $serializer):JsonResponse
    {
        $praticienList = $praticienRepository->findAll();
        $jsonPraticienList = $serializer->serialize($praticienList, 'json', ['groups'=>'getPatients']);
        return new JsonResponse($jsonPraticienList, Response::HTTP_OK, [], true);

    }


    //Route pour obtenir praticien par ID
    #[Route('/api/praticiens/{id}', name: 'detailPraticien', methods: ['GET'])]
    public function getDetailPraticien(Praticien $praticien, int $id,SerializerInterface $serializer, PraticienRepository $praticienRepository):JsonResponse
    {
        // méthode avec ParamConverter il faut ajouter Patient $patient dans les paramètres de la méthode
        $jsonPraticien = $serializer->serialize($praticien, 'json', ['groups'=>'getPatients']);
        return new JsonResponse($jsonPraticien, Response::HTTP_OK, ['accept' => 'json'], true);

    }

   /* #[Route('/praticien', name: 'app_praticien')]
    public function index(): Response
    {
        return $this->render('praticien/index.html.twig', [
            'controller_name' => 'PraticienController',
        ]);
    }*/
}
