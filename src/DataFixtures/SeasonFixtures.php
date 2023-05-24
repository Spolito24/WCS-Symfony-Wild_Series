<?php

namespace App\DataFixtures;

use App\Entity\Program;
use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        foreach (ProgramFixtures::PROGRAM as $program) {
            for ($i = 1; $i <= 5; $i++) {
                $season = new Season();
                $season->setNumber($i);
                $season->setYear($faker->year());
                $season->setDescription($faker->paragraph(3, true));

                $season->setProgram($this->getReference('program_' . $program['title']));
                $this->addReference('season' . $i . '_' . $program['title'], $season);
                $manager->persist($season);
            }
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
