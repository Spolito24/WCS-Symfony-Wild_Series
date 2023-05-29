<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ActorFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($i = 1; $i <= 10; $i++) {
            $actor = new Actor();
            $actor->setFirstname($faker->firstName());
            $actor->setLastname($faker->lastName());
            $actor->setBirthDate($faker->dateTime());

            $program = ProgramFixtures::PROGRAM;
            for ($j = 1; $j <= 3; $j++) {
                $programKey = array_rand($program);
                $actor->addProgram($this->getReference('program_' . $program[$programKey]['title']));
            }

            $this->addReference('actor_' . $actor->getFirstname() . '_' . $actor->getLastname(), $actor);
            $manager->persist($actor);
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
