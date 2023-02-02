<?php

namespace App\Controller;

use App\Entity\Facture;
use App\Entity\Rdv;
use App\Repository\FactureRepository;
use App\Repository\PatientRepository;
use App\Repository\PraticienRepository;
use App\Repository\RdvRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class FactureController extends AbstractController
{
    #[Route('/api/factures', name: 'facture', methods: ['GET'])]
    public function getFactureList(FactureRepository $factureRepository, SerializerInterface $serializer):JsonResponse
    {
        $factureList = $factureRepository->findAll();
        $jsonFactureList = $serializer->serialize($factureList, 'json', ['groups'=>'getPatients']);
        return new JsonResponse($jsonFactureList, Response::HTTP_OK, [], true);
    }


    #[Route('/api/factures/{id}', name: 'detailFacture', methods: ['GET'])]
    public function getDetailFacture(Facture $facture, int $id,SerializerInterface $serializer, FactureRepository $factureRepository): JsonResponse
    {
        // méthode avec ParamConverter il faut ajouter Facture $facture dans les paramètres de la méthode
        $jsonFacture = $serializer->serialize($facture, 'json', ['groups'=>'getPatients']);
        return new JsonResponse($jsonFacture, Response::HTTP_OK, ['accept' => 'json'], true);
    }

    #[Route('/api/factures', name : 'createFacture', methods: ['POST'])]
    public function createFacture(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, UrlGeneratorInterface $urlGenerator,
                              PraticienRepository $praticienRepository, PatientRepository $patientRepository, RdvRepository  $rdvRepository): JsonResponse
    {
        $facture =$serializer->deserialize($request->getContent(), Facture::class, 'json');

        $content=$request->toArray();

        //récupération de l'idPatient, -1 par défaut si non défini
        //recherche du patient qui correspond et on l'assigne à la facture
        $idPatient=$content['idPatient'] ?? -1;
        $facture->setPatient($patientRepository->find($idPatient));

        //récupération de l'idPraticien, -1 par défaut si non défini
        //recherche du praticien qui correspond et on l'assigne à la facture
        $idPraticien=$content['idPraticien'] ?? -1;
        $facture->setPraticien($praticienRepository->find($idPraticien));

        //récupération de l'idRdv, -1 par défaut si non défini
        //recherche du Rdv qui correspond et on l'assigne à la facture
        $idRdv=$content['idRdv'] ?? -1;
        $facture->setRdv($rdvRepository->find($idRdv));


        $em->persist($facture);
        $em->flush();

        $jsonRdv=$serializer->serialize($facture, 'json', ['groups'=>'getPatients']);

        $location=$urlGenerator->generate('detailPatient', ['id'=>$facture->getId()],
            UrlGeneratorInterface::ABSOLUTE_URL);

        return new JsonResponse($jsonRdv, Response::HTTP_CREATED, ["Location"=>$location], true);
    }

    // méthode pour supprimer une facture
    #[Route('api/factures/{id}', name: 'deleteFacture', methods: ['DELETE'])]
    public function deleteFacture(Facture $facture, EntityManagerInterface $em): JsonResponse
    {
        $em->remove($facture);
        $em->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }



    //    #[Route('/facture', name: 'app_facture')]
//    public function index(): Response
//    {
//        return $this->render('facture/index.html.twig', [
//            'controller_name' => 'FactureController',
//        ]);
//    }
}
