<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
// use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
// use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    /**
     * listAction
     * 
     * @Route("/users", name="user_list")
     *
     * @param  UserRepository $repoUser
     * @return void
     */
    public function listAction(UserRepository $repoUser)
    {
        return $this->render('user/list.html.twig', ['users' => $repoUser->findAll()]);
    }

    /**
     * createAction
     * 
     * @Route("/users/create", name="user_create")
     *
     * @param  Request $request
     * @param  ManagerRegistry $doctrine
     * @param  UserPasswordHasherInterface $userPasswordHasher
     * @param  UserRepository $repoUser
     * @return void
     */
    public function createAction(Request $request, ManagerRegistry $doctrine, UserPasswordHasherInterface $userPasswordHasher, UserRepository $repoUser)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $doctrine->getManager();
            // $password = $this->get('security.password_encoder')->encodePassword($user, $user->getPassword());
            // $user->setPassword($password);

            // Checking the existence of the user
            if (
                $repoUser->ifExist($form->get('username')->getData())
            ) {
                $this->addFlash('error', "L'utilisateur existe déjà.");
                return $this->render('user/create.html.twig', ['form' => $form->createView()]);
            }
            // if ($repoUser->findOneBy(['username' => $form->get('username')->getData()]) !== null) {
            //     $this->addFlash('error', "L'utilisateur existe déjà.");
            //     return $this->render('user/create.html.twig', ['form' => $form->createView()]);
            // }

            // encode the password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $user->setRoles($form->get('roles')->getData());
            $manager->persist($user);
            $manager->flush();

            $this->addFlash('success', "L'utilisateur a bien été ajouté.");

            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * editAction
     * 
     * @Route("/users/{id}/edit", name="user_edit")
     *
     * @param  User $user
     * @param  Request $request
     * @param  ManagerRegistry $doctrine
     * @param  UserPasswordHasherInterface $userPasswordHasher
     * @return void
     */
    public function editAction(User $user, Request $request, ManagerRegistry $doctrine, UserPasswordHasherInterface $userPasswordHasher)
    {
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $password = $this->get('security.password_encoder')->encodePassword($user, $user->getPassword());
            // $user->setPassword($password);
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $doctrine->getManager()->flush();

            $this->addFlash('success', "L'utilisateur a bien été modifié");

            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/edit.html.twig', ['form' => $form->createView(), 'user' => $user]);
    }
}
