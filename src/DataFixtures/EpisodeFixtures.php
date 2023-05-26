<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        foreach (ProgramFixtures::PROGRAM as $program) {
            for ($i = 1; $i <= 35; $i++) {
                $episode = new Episode();
                $episode->setTitle($faker->sentence(3));
                $episode->setNumber($i);
                $episode->setSynopsis($faker->paragraph(4, true));
                $episode->setSeason($this->getReference('season' . $faker->numberBetween(1, 5) . '_' . $program['title']));
                $manager->persist($episode);
            }
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
