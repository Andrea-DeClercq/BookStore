<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

;

class UserFixtures extends Fixture implements FixtureGroupInterface
{
    public const USER = '';

    public function __construct(
        private UserPasswordHasherInterface $hasher,
        private $secretPassword
        )
    {
        $this->secretPassword = $secretPassword;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');


        $adminUser = new User();
        $adminUser->setUsername('admin');
        $adminPassword = $this->hasher->hashPassword($adminUser, $this->secretPassword);
        $adminUser->setPassword($adminPassword);
        $adminUser->setEmail('admin@admin.fr');
        $adminUser->setRoles(['ROLE_ADMIN']);
        $manager->persist($adminUser);

        for($u = 0; $u < 20; $u++){
            $user = new User();

            $username = $faker->firstName();
            $password = $this->hasher->hashPassword($user,$username);

            $user->setUsername($username);

            $user->setEmail($username.$faker->randomNumber().'@gmail.com');
            
            $user->setPassword($password);

            $user->setFirstname($username);

            $user->setLastname($faker->lastName());
            $manager->persist($user);
            $this->addReference(User::class.'_'.$u, $user);
        }

        $manager->flush();
    }

    public static function getGroups():array
    {
        return['user'];
    }
}
