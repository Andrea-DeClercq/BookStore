<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
;

class BookFixtures extends Fixture implements FixtureGroupInterface
{
    
    public const BOOK = '';

    public const STATUS = [
        0 => 'Neuf',
        1 => 'Légèrement écorché',
        2 => 'Plié',
        3 => 'Déformé',
        4 => 'Couverture abîmé',
        5 => 'Fragile',
        6 => 'Pages manquantes',
        7 => 'Marque de crayon',
        8 => 'Occasion',
        9 => 'Correct',
    ];

    public function getDependencies(){
        return [
            AuthorFixtures::class
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        for($b = 0; $b < 85; $b++)
        {
            $book = new Book();

            $book->setTitle($faker->sentence());
            $book->setDescription($faker->paragraph());
            $book->setReleaseDate($faker->dateTimeInInterval());
            $book->setStatus(self::STATUS[$faker->randomDigit()]);
            $book->addAuthor($this->getReference(Author::class.'_'.mt_rand(0,14)));
            $manager->persist($book);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return['book'];
    }
}
