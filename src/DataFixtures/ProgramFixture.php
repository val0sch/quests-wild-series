<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixture extends Fixture implements DependentFixtureInterface
{
    public const PROGRAM = [

        [
            'title' => 'american horror story',
            'synopsis' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
            'poster' => 'https://blog.slate.fr/wp-content/blogs.dir/23/files/2011/05/retro-tv-icon.jpg',
            'country' => 'USA',
            'year' => '2008',
            'category' => 'Horreur'
        ],
        [
            'title' => 'breaking bad',
            'synopsis' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
            'poster' => 'https://blog.slate.fr/wp-content/blogs.dir/23/files/2011/05/retro-tv-icon.jpg',
            'country' => 'USA',
            'year' => '2001',
            'category' => 'Action'
        ],
        [
            'title' => 'the servant',
            'synopsis' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
            'poster' => 'https://blog.slate.fr/wp-content/blogs.dir/23/files/2011/05/retro-tv-icon.jpg',
            'country' => 'USA',
            'year' => '2019',
            'category' => 'Action'
        ],     [
            'title' => 'game of thrones',
            'synopsis' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
            'poster' => 'https://blog.slate.fr/wp-content/blogs.dir/23/files/2011/05/retro-tv-icon.jpg',
            'country' => 'USA',
            'year' => '2002',
            'category' => 'Fantastique'
        ],     [
            'title' => 'Fleabag',
            'synopsis' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
            'poster' => 'https://blog.slate.fr/wp-content/blogs.dir/23/files/2011/05/retro-tv-icon.jpg',
            'country' => 'England',
            'year' => '2015',
            'category' => 'Aventure'
        ]

    ];

    public function load(ObjectManager $manager): void
    {
        foreach (SELF::PROGRAM as $key => $program) {
            $serie = new Program();
            ++$key;
            $serie->setId($key)
                ->setTitle($program['title'])
                ->setSynopsis($program['synopsis'])
                ->setPoster($program['poster'])
                ->setCategory($this->getReference('category_' . $program['category']))
                ->setCountry($program['country'])
                ->setYear($program['year']);
            $manager->persist($serie);
            $this->setReference('program_' . $key, $serie);
        }


        $manager->flush();
    }

    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
        return [
            CategoryFixture::class,
        ];
    }
}
