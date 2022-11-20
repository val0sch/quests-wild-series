<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
//Tout d'abord nous ajoutons la classe Factory de FakerPhp
use Faker\Factory;

class SeasonFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // nous demandons à la Factory de nous fournir un Faker
        $faker = Factory::create();
        // $product = new Product();
        /**
         * 
         * L'objet $faker que tu récupère est l'outil qui va te permettre 
         * de te générer toutes les données que tu souhaites
         */

        //  ***************** MERCI MARIE XD ************

        // je boucle sur mes 5 programs
        for ($i = 1; $i <= 5; $i++) {
            // je boucle pour preparer 5 saisons par program
            for ($j = 1; $j <= 5; $j++) {

                $season = new Season();
                //Ce Faker va nous permettre d'alimenter l'instance de Season que l'on souhaite ajouter en base
                $season
                    ->setNumber($j)
                    ->setYear($faker->year())
                    ->setDescription($faker->paragraphs(3, true))
                    ->setProgram($this->getReference('program_' . $i));

                $this->setReference('season_reference_' . $j . '-program_' . $i, $season);
                $manager->persist($season);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {

        return [
            ProgramFixture::class,
        ];
    }
}
