<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }


    const PROGRAM = [
        ["title" => "Breaking Bad", "synopsis" => "Un prof de chimie ce décide à fabriquer de la meth", "category" => "Action", "country" => "USA", "year" => "2008"],
        ["title" => "One Piece", "synopsis" => "Un jeune pirate cherche le plus grand des trésors afin de devenir le roi des pirates", "category" => "Aventure", "country" => "Japon", "year" => "1999"],
        ["title" => "South Park", "synopsis" => "Dessin animé qui suit les aventures absurde de quatre enfants dans la ville de South Park", "category" => "Animation", "country" => "USA", "year" => "1997"],
        ["title" => "The Mandalorian", "synopsis" => "l'histoire d'un chasseur de prime de l'univers de Star Wars", "category" => "Fantastique", "country" => "USA", "year" => "2019"],
        ["title" => "Walking dead", "synopsis" => "Des zombies envahissent la terre", "category" => "Horreur", "country" => "USA", "year" => "2008"],
    ];
    public function load(ObjectManager $manager): void
    {
        foreach (self::PROGRAM as $programData) {
            $program = new Program();
            $program->setTitle($programData['title']);
            $slug = $this->slugger->slug($programData['title']);
            $program->setSlug($slug);
            $program->setSynopsis($programData['synopsis']);
            $program->setCountry($programData['country']);
            $program->setYear($programData['year']);
            $program->setCategory($this->getReference('category_' . $programData['category']));
            $this->addReference('program_' . $programData['title'], $program);
            $manager->persist($program);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
        ];
    }
}
