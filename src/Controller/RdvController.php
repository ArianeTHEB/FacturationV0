<?php

namespace App\Controller;


use App\Entity\Patient;
use App\Entity\Rdv;
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

class RdvController extends AbstractController
{

    //Route pour obtenir liste de TOUS les rdv
    #[Route('/api/rdvs', name: 'rdv', methods: ['GET'])]
    public function getRdvList(RdvRepository $rdvRepository, SerializerInterface $serializer):JsonResponse
    {
        $rdvList = $rdvRepository->findAll();
        $jsonRdvList = $serializer->serialize($rdvList, 'json', ['groups'=>'getPatients']);
        return new JsonResponse($jsonRdvList, Response::HTTP_OK, [], true);
    }


    //Route pour obtenir rdv par ID
    #[Route('/api/rdvs/{id}', name: 'detailRdv', methods: ['GET'])]
    public function getRdvPatient(Rdv $rdv, SerializerInterface $serializer, RdvRepository $rdvRepository): JsonResponse
    {
        // méthode avec ParamConverter il faut ajouter Patient $patient dans les paramètres de la méthode
        $jsonRdv = $serializer->serialize($rdv, 'json', ['groups'=>'getPatients']);
        return new JsonResponse($jsonRdv, Response::HTTP_OK, ['accept' => 'json'], true);

    }

    //méthode pour créer un rdv
    #[Route('/api/rdvs', name: 'createRdv', methods: ['POST'])]
    public function createRdv(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, UrlGeneratorInterface $urlGenerator,
                              PraticienRepository $praticienRepository, PatientRepository $patientRepository): JsonResponse
    {
        $rdv =$serializer->deserialize($request->getContent(), Rdv::class, 'json');

        //récupération de l'ensemble des données envoyées sous forme de tableau
        $content=$request->toArray();

       //récupération de l'idPatient, -1 par défaut si non défini
        $idPatient=$content['idPatient'] ?? -1;

        //recherche du patient qui correspond et on l'assigne au rdv
        //si "find" ne trouve pas, null sera retourné
        $rdv->setRdvPatient($patientRepository->find($idPatient));

        //récupération de l'idPraticien, -1 par défaut si non défini
        $idPraticien=$content['idPraticien'] ?? -1;

        //recherche du praticien qui correspond et on l'assigne au rdv
        //si "find" ne trouve pas, null sera retourné
        $rdv->setRdvPraticien($praticienRepository->find($idPraticien));


        $em->persist($rdv);
        $em->flush();

        $jsonRdv=$serializer->serialize($rdv, 'json', ['groups'=>'getPatients']);

        $location=$urlGenerator->generate('detailPatient', ['id'=>$rdv->getId()],
            UrlGeneratorInterface::ABSOLUTE_URL);

        return new JsonResponse($jsonRdv, Response::HTTP_CREATED, ["Location"=>$location], true);
    }

    //Methods pour mettre à jour un rdv
    #[Route('api/rdvs/{id}', name : 'upDateRdv', methods: ['PUT'])]
    public function upDateRdv(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, PraticienRepository $praticienRepository, PatientRepository $patientRepository, Rdv $currentRdv): JsonResponse
    {
        $upDateRdv=$serializer->deserialize($request->getContent(),Rdv::class, 'json',
            [AbstractNormalizer::OBJECT_TO_POPULATE=>$currentRdv]);

        $content=$request->toArray();
        $idPatient=$content['idPatient'] ?? -1;
        $upDateRdv->setRdvPatient($patientRepository->find($idPatient));

        $content=$request->toArray();
        $idPraticien=$content['idPraticien'] ?? -1;
        $upDateRdv->setRdvPraticien($praticienRepository->find($idPraticien));

        $em->persist($upDateRdv);
        $em->flush();
        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }


    // méthode pour supprimer un rdv
    #[Route('api/rdvs/{id}', name: 'deleteRdv', methods: ['DELETE'])]
    public function deleteRdv(Rdv $rdv, EntityManagerInterface $em): JsonResponse
    {
        $em->remove($rdv);
        $em->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }



//    #[Route('/rdv', name: 'app_rdv')]
//    public function index(): Response
//    {
//        return $this->render('rdv/index.html.twig', [
//            'controller_name' => 'RdvController',
//        ]);
//    }
}
