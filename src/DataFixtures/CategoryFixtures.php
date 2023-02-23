<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

// Ajout de FakerPHP
use Faker;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

//        // Une première catégorie
//
//        for ($i = 0; $i < 20; $i++) {
//
//        $category = new Category();
//        $category->setLabel("Souris");
//        $category->setDateajout(new \Datetime);
//        $manager->persist($category);
//        $manager->flush($category);
//    }

        $faker = Faker\Factory::create('fr_FR');

        $aCat = ["Ecrans", "Claviers", "Tablettes", "Casques"];

        foreach ($aCat as $item)
        {
            // Une seconde catégorie
            $category = new Category();

            $category->setLabel($item);
            // $category->setDateajout(new \Datetime);

//             intervalle de dates (ici du lendemain et jusquà dans 30 jours)
            $category->setDateajout($faker->dateTimeInInterval($startDate = '+ 1 days', $interval = '+30 day', $timezone = null));
            $manager->persist($category);
        }

        $manager->flush();
    }
}