<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\NewUsersEntity;
use App\Form\FormType;
class AdminDashbordController extends AbstractController
{
    #[Route('/admin/dashbord', name: 'app_admin_dashbord')]
    public function index(Request $request,EntityManagerInterface $entityManager,UserPasswordHasherInterface $passwordHasher): Response
    {
        $currentUser = $this->getUser();
        $newUser = new NewUsersEntity();
        $form = $this->createForm(FormType::class, $newUser,['method'=>'POST']);

        $form->handleRequest($request);
        $errors = [];
        if ($form->isSubmitted()){
            //Check if user exist in a db
            $existingUser = $entityManager->getRepository(NewUsersEntity::class)->findOneBy(['email' => $newUser->getEmail()]);
            if($existingUser){
                foreach ($form->getErrors(true) as $error) {
                    $errors[] = $error->getMessage();
                }
                return $this->render('admin_dashbord/index.html.twig', [
                    'user'=> $currentUser,
                    'form'=>$form->createView(),
                    'errors'=>$errors
                ]);
            }
            if ($form->isValid()){
                $this->addFlash('success', "User was created!");
                //Make hash password for new users
                $hashedPassword = $passwordHasher->hashPassword(
                    $newUser,
                    $newUser->getPassword()
                );
                $newUser->setPassword($hashedPassword);
                $entityManager->persist($newUser);
                $entityManager->flush();
            }
        }
        return $this->render('admin_dashbord/index.html.twig', [
            'user'=> $currentUser,
            'form'=>$form,
            'errors'=>$errors
        ]);
    }
}
