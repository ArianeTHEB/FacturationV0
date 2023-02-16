<?php

namespace App\DataFixtures;

use App\Entity\Patient;
use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\FixtureInterface;use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture implements FixtureInterface
{
    private $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher){
        $this->userPasswordHasher=$userPasswordHasher;
    }

    public function load(ObjectManager $manager): void
    {

        //Création d'un User
        $user = new Utilisateur();
        $user->setEmail("utilisatrice@factureapi.com");
        $user->setRoles(["ROLE_USER"]);
        $user->setPassword($this->userPasswordHasher->hashPassword($user, "password"));
        $manager->persist($user);

        //Création d'un Administrateur
        $administrateur= new Utilisateur();
        $administrateur->setEmail("admin@factureapi.com");
        $administrateur->setRoles(["ROLE_ADMIN"]);
        $administrateur->setPassword($this->userPasswordHasher->hashPassword($administrateur, "password"));
        $manager->persist($administrateur);


       // Création d'une dizaine de patients
        for ($i = 0; $i < 10; $i++) {
            $patient = new Patient;
            $patient->setNom('NomFamille' . $i);
            $patient->setPrenom('Prenom' . $i);
            $patient->setTelephone('0' . $i);
            $manager->persist($patient);
            $patient->setAdresseMail('adresse_mail' . $i);

            $manager->flush();
        }
    }

}
