<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\String\Slugger\SluggerInterface;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        foreach (ProgramFixtures::PROGRAM as $program) {
            for ($i = 1; $i <= 35; $i++) {
                $episode = new Episode();
                $episode->setTitle($faker->sentence(3));
                $slug = $this->slugger->slug($episode->getTitle());
                $episode->setSlug($slug);
                $episode->setNumber($i);
                $episode->setSynopsis($faker->paragraph(4, true));
                $episode->setSeason($this->getReference('season' . $faker->numberBetween(1, 5) . '_' . $program['title']));
                $episode->setDuration($faker->numberBetween(15, 80));
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
