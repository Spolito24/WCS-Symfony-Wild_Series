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
        ["title" => "Série très cool", "synopsis" => "Super série", "category" => "Fantastique"],
        ["title" => "Série très cool 2", "synopsis" => "Super série le numéro 2", "category" => "Fantastique"],
        ["title" => "Série très cool VS Série très nul", "synopsis" => "Super série contre une série très nul", "category" => "Action"],
        ["title" => "Série très cool la revanche", "synopsis" => "La super série ce venge après avoir été battu par une série nul", "category" => "Fantastique"],
    ];
    public function load(ObjectManager $manager): void
    {
        foreach (self::PROGRAM as $programData) {
            $program = new Program();
            $program->setTitle($programData['title']);
            $program->setSynopsis($programData['synopsis']);
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
