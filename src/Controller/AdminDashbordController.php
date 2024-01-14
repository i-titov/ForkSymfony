<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\NewUsersEntity;
use App\Form\FormType;
class AdminDashbordController extends AbstractController
{
    #[Route('/admin/dashbord', name: 'app_admin_dashbord')]
    public function index(Request $request,EntityManagerInterface $entityManager): Response
    {
        $currentUser = $this->getUser();
        $newUser = new NewUsersEntity();
        $form = $this->createForm(FormType::class, $newUser);

        $form->handleRequest($request);
        $errors = [];
        if($request->isMethod('post')){
            $existingUser = $entityManager->getRepository(NewUsersEntity::class)->findOneBy(['email' => $newUser->getEmail()]);
            if($existingUser){
                $errors[] = 'User exist, write new an email';
                return $this->render('admin_dashbord/index.html.twig', [
                    'user'=> $currentUser,
                    'form'=>$form->createView(),
                    'errors'=>$errors
                ]);
            }
            if ($form->isSubmitted() && $form->isValid()){
                $this->addFlash('notice', "User was created !");
                $entityManager->persist($newUser);
                $entityManager->flush();
                return $this->render('admin_dashbord/index.html.twig', [
                    'user'=> $currentUser,
                    'form'=>$form,
                    'errors'=>$errors
                ]);
            }else{
                foreach ($form->getErrors(true) as $error) {
                    $errors[] = $error->getMessage();
                }
                return $this->render('admin_dashbord/index.html.twig', [
                    'user'=> $currentUser,
                    'form'=>$form->createView(),
                    'errors'=>$errors
                ]);
            }
        }
        return $this->render('admin_dashbord/index.html.twig', [
            'user'=> $currentUser,
            'form'=>$form,
            'errors'=>$errors
        ]);
    }

    private function msg(bool $success, string $userName = null):string{
        if(!$success){
            return 'Quelque chose s\'est mal passé';
        }
        return "l\'utilisateur a été ajouté";
    }
}
