<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    private UserPasswordHasherInterface $passwordHasher;
    public function __construct(UserPasswordHasherInterface $passwordHasher){

        $this->passwordHasher = $passwordHasher;

    }

    public function load(ObjectManager $manager): void
    {

        $user = new User();
        $user->setName('Toto');
        $user->setFirstname('Tata');
        $user->setEmail('user@user.fr');
        $hash = $this->passwordHasher->hashPassword($user, 'user');
        $user->setPassword($hash);
        $manager->persist($user);

        $admin = new User();
        $admin->setName('Monsieur');
        $admin->setFirstname('Admin');
        $admin->setEmail('admin@admin.fr');
        $adminHash = $this->passwordHasher->hashPassword($admin, 'admin');
        $admin->setPassword($adminHash);
        $admin->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);


        $manager->flush();
    }
}
