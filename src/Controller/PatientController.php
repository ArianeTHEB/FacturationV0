<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Repository\PatientRepository;
use App\Repository\PraticienRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class PatientController extends AbstractController
{
    //Route pour obtenir liste de TOUS les patients
    #[Route('/api/patients', name: 'patient', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN', message : 'Vous n avez pas acces a ces informations')]
    public function getPatientList(PatientRepository $patientRepository, SerializerInterface $serializer):JsonResponse

    {
        $patientList = $patientRepository->findAll();
        $jsonPatientList = $serializer->serialize($patientList, 'json', ['groups'=>'getPatients']);
        return new JsonResponse($jsonPatientList, Response::HTTP_OK, [], true);

    }


    //Route pour obtenir patient par ID
    #[Route('/api/patients/{id}', name: 'detailPatient', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN', message : 'Vous n avez pas acces a ces informations')]
    public function getDetailPatient(Patient $patient, int $id,SerializerInterface $serializer, PatientRepository $patientRepository): JsonResponse
    {
        // méthode avec ParamConverter il faut ajouter Patient $patient dans les paramètres de la méthode
        $jsonPatient = $serializer->serialize($patient, 'json', ['groups'=>'getPatients']);
        return new JsonResponse($jsonPatient, Response::HTTP_OK, ['accept' => 'json'], true);

    }


    // méthode pour supprimer un patient
    #[Route('api/patients/{id}', name: 'deletePatient', methods: ['DELETE'])]
    #[IsGranted('ROLE_ADMIN', message : 'Vous n avez pas acces a ces informations')]
    public function deletePatient(Patient $patient, EntityManagerInterface $em): JsonResponse
    {
        $em->remove($patient);
        $em->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }


    //méthode pour créer un patient
    #[Route('/api/patients', name: 'createPatient', methods: ['POST'])]
    public function createPatient(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, UrlGeneratorInterface $urlGenerator, PraticienRepository $praticienRepository, ValidatorInterface $validator): JsonResponse
    {
        $patient =$serializer->deserialize($request->getContent(), Patient::class, 'json');

        //Verification des erreurs
        $errors=$validator->validate($patient);

        if($errors->count()>0) {
            return new JsonResponse($serializer->serialize($errors, 'json'), JsonResponse::HTTP_BAD_REQUEST, [], true);
        }

        //récupération de l'ensemble des données envoyées sous forme de tableau
        $content=$request->toArray();

        //récupération de l'idPraticien, -1 par défaut si non défini
        $idPraticien=$content['idPraticien'] ?? -1;

        //recherche du praticien qui correspond et on l'assigne au patient
        //si "find" ne trouve pas, null sera retourné
        $patient->setPraticien($praticienRepository->find($idPraticien));

        $em->persist($patient);
        $em->flush();

        $jsonPatient=$serializer->serialize($patient, 'json', ['groups'=>'getPatients']);

        $location=$urlGenerator->generate('detailPatient', ['id'=>$patient->getId()],
        UrlGeneratorInterface::ABSOLUTE_URL);

        return new JsonResponse($jsonPatient, Response::HTTP_CREATED, ["Location"=>$location], true);
    }
    
    //méthode pour mettre à jour le patient
    #[Route('api/patients/{id}', name: 'upDatePatient', methods:['PUT'])]
    public function updatePatient(Request $request, SerializerInterface $serializer, Patient $currentPatient, EntityManagerInterface $em, PraticienRepository $praticienRepository): JsonResponse
    {
        $updatePatient=$serializer->deserialize($request->getContent(),Patient::class,'json',
        [AbstractNormalizer::OBJECT_TO_POPULATE=>$currentPatient]);

    $content=$request->toArray();
    $idPraticien=$content['idPraticien'] ?? -1;
    $updatePatient->setPraticien($praticienRepository->find($idPraticien));

    $em->persist($updatePatient);
    $em->flush();
    return  new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }


  /*Route pré existante dans controller
  #[Route('/patient', name: 'app_patient')]
    public function index(): Response
    {
        return $this->json([
            'message'=> 'Welcome to your new controller!',
            'path' => 'src/Controller/PatientController.php',
        ]);
    }*/
}
