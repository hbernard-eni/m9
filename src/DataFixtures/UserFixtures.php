<?php

namespace App\DataFixtures;

use App\Entity\Participant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

// Ajout de FakerPHP
// https://fakerphp.github.io/formatters
use Faker;

// PasswordHasher
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

          for ($i = 0; $i < 20; $i++) {

            $participant = new Participant();
            $participant->setEmail($faker->email());
            $participant->setFirstname($faker->firstName());
            $participant->setLastname($faker->lastName());
            $participant->setRoles(["ROLE_USER"]);
            $participant->setAddress($faker->streetAddress());
            $participant->setPostcode($faker->postcode());
            $participant->setCity($faker->city());
            $participant->setPhone($faker->mobileNumber());

            $plainPassword = "azerty";

            $hash = $this->hasher->hashPassword($participant, $plainPassword);
            $participant->setPassword($hash);

        $manager->persist($participant);
        }

        $manager->flush();

    }
}
