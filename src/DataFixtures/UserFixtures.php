<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
// use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(

        private UserPasswordHasherInterface $hasher

    ){

    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('rafael@email.com');

        $password = $this->hasher->hashPassword($user, '123456');
        $user->setPassword($password);

        $manager->persist($user);
        $manager->flush();
    }
}
