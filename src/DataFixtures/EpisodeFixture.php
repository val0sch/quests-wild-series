<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class EpisodeFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        // $product = new Product();
        /**
         * 
         * L'objet $faker que tu récupère est l'outil qui va te permettre 
         * de te générer toutes les données que tu souhaites
         */

        //  ***************** MERCI MARIE XD ************

        // je boucle sur mes 5 saisons
        for ($i = 1; $i <= 5; $i++) {
            // je boucle pour preparer épisodes par saison
            for ($j = 1; $j <= 10; $j++) {
                $episode = new Episode();
                //Ce Faker va nous permettre d'alimenter l'instance de Season que l'on souhaite ajouter en base
                $episode
                    ->setTitle($faker->words(3, true))
                    ->setNumber($j)
                    ->setDescription($faker->paragraphs(2, true))
                    ->setSeason($this->getReference('season_' . $i));

                $manager->persist($episode);
            }
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont EpisodeFixtures dépend
        return [
            SeasonFixture::class,
        ];
    }
}
