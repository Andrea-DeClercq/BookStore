<?php

namespace App\DataFixtures;

use App\Entity\Author;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
;

class AuthorFixtures extends Fixture implements FixtureGroupInterface
{
    public const AUTHOR = '';

    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        for ($a = 0; $a < 15; $a++){
            $author = new Author();
            $author->setFirstname($faker->firstName());
            $author->setLastname($faker->lastName());
            $author->setBirthday($faker->dateTimeBetween('-28 years'));
            $manager->persist($author);
            $this->addReference(Author::class. '_'. $a, $author);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return['author'];
    }
}
