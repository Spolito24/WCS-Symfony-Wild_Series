<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    const PROGRAM = [
        ["title" => "Breaking Bad", "synopsis" => "Un prof de chimie ce décide à fabriquer de la meth", "category" => "Action"],
        ["title" => "One Piece", "synopsis" => "Un jeune pirate cherche le plus grand des trésors afin de devenir le roi des pirates", "category" => "Aventure"],
        ["title" => "South Park", "synopsis" => "Dessin animé qui suit les aventures absurde de quatre enfants", "category" => "Animation"],
        ["title" => "The Mandalorian", "synopsis" => "l'histoire d'un chasseur de prime de l'univers de Star Wars", "category" => "Fantastique"],
        ["title" => "Walking dead", "synopsis" => "Des zombies envahissent la terre", "category" => "Horreur"],
    ];
    public function load(ObjectManager $manager): void
    {
        foreach (self::PROGRAM as $movie) {
            $program = new Program();
            $program->setTitle($movie['title']);
            $program->setSynopsis($movie['synopsis']);
            $program->setCategory($this->getReference('category_' . $movie['category']));
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
