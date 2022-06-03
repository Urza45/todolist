<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $userPasswordHasher = new UserPasswordHasherInterface();
        // $product = new Product();
        // $manager->persist($product);
        $users = [
            [
                "username" => "admin",
                "email" => "admin@todo.fr",
                "role" => '"ROLE_ADMIN"',
                "password" => "admin",
            ],
            [
                "username" => "anonyme",
                "email" => "anonyme@todo.fr",
                "role" => '"ROLE_USER"',
                "password" => "anonyme",
            ],
            [
                "username" => "user",
                "email" => "user@todo.fr",
                "role" => '"ROLE_USER"',
                "password" => "user",
            ],
            [
                "username" => "user2",
                "email" => "user2@todo.fr",
                "role" => '"ROLE_USER"',
                "password" => "user2",
            ],
            [
                "username" => "user3",
                "email" => "user3@todo.fr",
                "role" => '"ROLE_USER"',
                "password" => "user3",
            ],
        ];
        foreach ($users as $individu){
            $user = new User();
            $user->setUsername($individu['username']);
            $user->setEmail($individu['email']);
            $user->setRoles([$individu['role']]);
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $individu['password']
                )
            );
            

        }


        $manager->flush();
    }
}
