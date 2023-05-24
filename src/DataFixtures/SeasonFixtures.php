<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    const SEASON = [
        ["number" => "1", "year" => "2008", "description" => "Walter White un profésseur de chimie décide de ce mettre à vendre de la meth après avoir été diagnostiquer d'un cancer", "program" => "Breaking Bad"],
        ["number" => "2", "year" => "2010", "description" => "Walter White est perdu entre arrêté la vente de meth et reprendre sont buisness", "program" => "Breaking Bad"],
        ["number" => "3", "year" => "2011", "description" => "Walter vend de la meth avec gustavo fring", "program" => "Breaking Bad"],
        ["number" => "4", "year" => "2012", "description" => "Walter est devenu taré (il tente de tuer un gosse)", "program" => "Breaking Bad"],

        ["number" => "1", "year" => "2019", "description" => "un chasseur de prime découvre un jeune enfant abondonné", "program" => "The Mandalorian"],
        ["number" => "2", "year" => "2021", "description" => "le chasseur est toujours accompagné de ce jeune enfant et fais des trucs je crois", "program" => "The Mandalorian"],
        ["number" => "3", "year" => "2023", "description" => "pas encore vu :(", "program" => "The Mandalorian"],

        ["number" => "1", "year" => "1999", "description" => "luffy cherche des compagnon", "program" => "One Piece"],
        ["number" => "2", "year" => "2001", "description" => "luffy ce bat contre un crocodile et libère un pays", "program" => "One Piece"],

        ["number" => "17", "year" => "2018", "description" => "le père de kyle devient un troll et les danois tente de l'arrêter", "program" => "South Park"],
        ["number" => "18", "year" => "2019", "description" => "Mr garisson devient le président des Etats Unis", "program" => "South Park"],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::SEASON as $seasonData) {
            $season = new Season();
            $season->setNumber($seasonData['number']);
            $season->setYear($seasonData['year']);
            $season->setDescription($seasonData['description']);
            $season->setProgram($this->getReference('program_' . $seasonData['program']));
            $this->addReference('season' . $seasonData['number'] . '_' . $seasonData['program'], $season);
            $manager->persist($season);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ProgramFixtures::class,
        ];
    }
}
