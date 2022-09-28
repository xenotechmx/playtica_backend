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

        $user = new User();
        $user->setUsername('j.hwang');
        $password = $this->hasher->hashPassword($user, 'Pl4yt1c42022!');
        $user->setPassword($password);
        $user->setRoles(['ROLE_ADMIN']);        
        $user->setActive(true);
        $manager->persist($user);

        $user = new User();
        $user->setUsername('lluevia.lee');
        $password = $this->hasher->hashPassword($user, 'Pl4yt1c42022!');
        $user->setPassword($password);
        $user->setRoles(['ROLE_ADMIN']);        
        $user->setActive(true);
        $manager->persist($user);

        $user = new User();
        $user->setUsername('hks');
        $password = $this->hasher->hashPassword($user, 'Pl4yt1c42022!');
        $user->setPassword($password);
        $user->setRoles(['ROLE_ADMIN']);        
        $user->setActive(true);
        $manager->persist($user);

        $user = new User();
        $user->setUsername('pablo.son');
        $password = $this->hasher->hashPassword($user, 'Pl4yt1c42022!');
        $user->setPassword($password);
        $user->setRoles(['ROLE_ADMIN']);        
        $user->setActive(true);
        $manager->persist($user);

        $user = new User();
        $user->setUsername('davidlee');
        $password = $this->hasher->hashPassword($user, 'Pl4yt1c42022!');
        $user->setPassword($password);
        $user->setRoles(['ROLE_ADMIN']);        
        $user->setActive(true);
        $manager->persist($user);

        $user = new User();
        $user->setUsername('destiny.hwang');
        $password = $this->hasher->hashPassword($user, 'Pl4yt1c42022!');
        $user->setPassword($password);
        $user->setRoles(['ROLE_ADMIN']);        
        $user->setActive(true);
        $manager->persist($user);

        $user = new User();
        $user->setUsername('jhpark');
        $password = $this->hasher->hashPassword($user, 'Pl4yt1c42022!');
        $user->setPassword($password);
        $user->setRoles(['ROLE_ADMIN']);        
        $user->setActive(true);
        $manager->persist($user);
        $manager->flush();
    }
}
