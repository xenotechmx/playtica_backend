<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{

    public function __construct(UserPasswordHasherInterface $hasher) {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setUsername('zahitrios');
        $password = $this->hasher->hashPassword($user, 'tyVe7i%3O791');
        $user->setPassword($password);
        $user->setRoles(['ROLE_ADMIN']);        
        $user->setActive(true);
        $manager->persist($user);
        $manager->flush();
    }
}
