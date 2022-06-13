<?php

namespace App\DataFixtures;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
// use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    /**
     * load
     *
     * @param  ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        // $userPasswordHasher = new UserPasswordHasherInterface();
        // $product = new Product();
        // $manager->persist($product);
        $users = [
            [
                "username" => "admin",
                "email" => "admin@todo.fr",
                "role" => '"ROLE_ADMIN"',
                // "password" => "admin",
                "password" => '$2y$13$g/xtMFCwsheZAdAbiQ15SuGSH.djMptExAgwphJwzLI862cg0ZhrG'
            ],
            [
                "username" => "user1",
                "email" => "user@todo.fr",
                "role" => '"ROLE_USER"',
                "password" => '$2y$13$g/xtMFCwsheZAdAbiQ15SuGSH.djMptExAgwphJwzLI862cg0ZhrG'
            ],
            [
                "username" => "user2",
                "email" => "user2@todo.fr",
                "role" => '"ROLE_USER"',
                "password" => '$2y$13$g/xtMFCwsheZAdAbiQ15SuGSH.djMptExAgwphJwzLI862cg0ZhrG'
            ],
            [
                "username" => "user3",
                "email" => "user3@todo.fr",
                "role" => '"ROLE_USER"',
                "password" => '$2y$13$g/xtMFCwsheZAdAbiQ15SuGSH.djMptExAgwphJwzLI862cg0ZhrG'
            ],
        ];

        $task = new Task();
        $date = new \DateTime();
        $isDone = random_int(0, 1);

        $task->setCreatedAt($date);
        $task->setTitle('Tache sans user 1');
        $task->setContent('Un exemple de tâche');
        $task->toggle($isDone);

        $manager->persist($task);

        $task = new Task();
        $date = new \DateTime();
        $isDone = random_int(0, 1);

        $task->setCreatedAt($date);
        $task->setTitle('Tache sans user 2');
        $task->setContent('Un exemple de tâche');
        $task->toggle($isDone);

        $manager->persist($task);

        foreach ($users as $individu) {
            $user = new User();
            $user->setUsername($individu['username']);
            $user->setEmail($individu['email']);
            $user->setRoles([$individu['role']]);
            $user->setPassword($individu['password']);
            //     $userPasswordHasher->hashPassword(
            //         $user,
            //         $individu['password']
            //     )
            // );
            $manager->persist($user);
            for ($i = 1; $i <= 5; $i++) {
                $task = new Task();
                $date = new \DateTime();
                $isDone = random_int(0, 1);

                $task->setCreatedAt($date);
                $task->setTitle('Tache n° ' . $i);
                $task->setContent('Un exemple de tâche ' . $i);
                $task->toggle($isDone);
                $task->setUSer($user);

                $manager->persist($task);
            }
        }

        $manager->flush();
    }
}
