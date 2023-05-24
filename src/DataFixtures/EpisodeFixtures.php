<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    const EPISODE = [
        ["title" => "Breaking", "number" => "1", "synopsis" => "Walter à un cancer", "program" => "Breaking Bad", "season" => "1"],
        ["title" => "Bad", "number" => "2", "synopsis" => "Walter va voir jesse", "program" => "Breaking Bad", "season" => "1"],
        ["title" => "Stop", "number" => "1", "synopsis" => "WWalter Arrête de faire de la drogue", "program" => "Breaking Bad", "season" => "2"],
        ["title" => "Walter", "number" => "1", "synopsis" => "Walter refais de la drogue", "program" => "Breaking Bad", "season" => "3"],

        ["title" => "des trolls", "number" => "1", "synopsis" => "l'école ce retrouve avec des trolls", "program" => "South Park", "season" => "17"],
        ["title" => "le père de kyle", "number" => "2", "synopsis" => "le père de kyle est un troll", "program" => "South Park", "season" => "17"],
        ["title" => "président", "number" => "1", "synopsis" => "mr garisson veut être président", "program" => "South Park", "season" => "18"],

        ["title" => "Star", "number" => "1", "synopsis" => "Une bonne série Star Wars ?!", "program" => "The Mandalorian", "season" => "1"],
        ["title" => "Wars", "number" => "2", "synopsis" => "Toujours Cool", "program" => "The Mandalorian", "season" => "1"],
    ];


    public function load(ObjectManager $manager): void
    {
        foreach (self::EPISODE as $episodeData) {
            $episode = new Episode();
            $episode->setTitle($episodeData['title']);
            $episode->setNumber($episodeData['number']);
            $episode->setSynopsis($episodeData['synopsis']);
            $episode->setSeason($this->getReference('season' . $episodeData['season'] . '_' . $episodeData['program']));
            $manager->persist($episode);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            SeasonFixtures::class,
        ];
    }
}
