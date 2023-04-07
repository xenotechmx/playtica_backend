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
        $user->setApiToken('e193b906-720e-415d-9027-06113735f4f7');
        $user->setRoles(['ROLE_ADMIN']);        
        $user->setActive(true);
        $manager->persist($user);

        $user = new User();
        $user->setUsername('j.hwang');
        $password = $this->hasher->hashPassword($user, 'Pl4yt1c42022!');
        $user->setPassword($password);
        $user->setApiToken(sha1(mt_rand(1, 90000) . 'SALT'));
        $user->setRoles(['ROLE_ADMIN']);        
        $user->setActive(true);
        $manager->persist($user);

        $user = new User();
        $user->setUsername('lluevia.lee');
        $password = $this->hasher->hashPassword($user, 'Pl4yt1c42022!');
        $user->setPassword($password);
        $user->setApiToken(sha1(mt_rand(1, 90000) . 'SALT'));
        $user->setRoles(['ROLE_ADMIN']);        
        $user->setActive(true);
        $manager->persist($user);

        $user = new User();
        $user->setUsername('hks');
        $password = $this->hasher->hashPassword($user, 'Pl4yt1c42022!');
        $user->setPassword($password);
        $user->setApiToken(sha1(mt_rand(1, 90000) . 'SALT'));
        $user->setRoles(['ROLE_ADMIN']);        
        $user->setActive(true);
        $manager->persist($user);

        $user = new User();
        $user->setUsername('pablo.son');
        $password = $this->hasher->hashPassword($user, 'Pl4yt1c42022!');
        $user->setPassword($password);
        $user->setApiToken(sha1(mt_rand(1, 90000) . 'SALT'));
        $user->setRoles(['ROLE_ADMIN']);        
        $user->setActive(true);
        $manager->persist($user);

        $user = new User();
        $user->setUsername('davidlee');
        $password = $this->hasher->hashPassword($user, 'Pl4yt1c42022!');
        $user->setPassword($password);
        $user->setApiToken(sha1(mt_rand(1, 90000) . 'SALT'));
        $user->setRoles(['ROLE_ADMIN']);        
        $user->setActive(true);
        $manager->persist($user);

        $user = new User();
        $user->setUsername('destiny.hwang');
        $password = $this->hasher->hashPassword($user, 'Pl4yt1c42022!');
        $user->setPassword($password);
        $user->setApiToken(sha1(mt_rand(1, 90000) . 'SALT'));
        $user->setRoles(['ROLE_ADMIN']);        
        $user->setActive(true);
        $manager->persist($user);

        $user = new User();
        $user->setUsername('jhpark');
        $password = $this->hasher->hashPassword($user, 'Pl4yt1c42022!');
        $user->setPassword($password);
        $user->setApiToken(sha1(mt_rand(1, 90000) . 'SALT'));
        $user->setRoles(['ROLE_ADMIN']);        
        $user->setActive(true);
        $manager->persist($user);
        $manager->flush();


        $user = new User();
        $user->setUsername('elena.franco');
        $password = $this->hasher->hashPassword($user, 'Pl4yt1c42022!');
        $user->setPassword($password);
        $user->setApiToken(sha1(mt_rand(1, 90000) . 'SALT'));
        $user->setRoles(['ROLE_ADMIN']);        
        $user->setActive(true);
        $manager->persist($user);
        $manager->flush();

        $user = new User();
        $user->setUsername('claudia.gil');
        $password = $this->hasher->hashPassword($user, 'Pl4yt1c42022!');
        $user->setPassword($password);
        $user->setApiToken(sha1(mt_rand(1, 90000) . 'SALT'));
        $user->setRoles(['ROLE_ADMIN']);        
        $user->setActive(true);
        $manager->persist($user);
        $manager->flush();
    }
}
