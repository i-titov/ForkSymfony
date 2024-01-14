<?php

namespace App\Controller;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\NewUsersEntity;

class AdminDashbordController extends AbstractController
{
    #[Route('/admin/dashbord', name: 'app_admin_dashbord')]
    public function index(Request $request,EntityManagerInterface $entityManager): Response
    {

        $currentUser = $this->getUser();
        $success = null;
        $newUser = new NewUsersEntity();
        $form = $this->createFormBuilder($newUser)
            ->add('firstname', TextType::class)
            ->add('lastname', TextType::class)
            ->add('email', EmailType::class)
            ->add('password', PasswordType::class)
            ->add('roles', ChoiceType::class, [
                'choices' => ['ROLE_ADMIN' => 'ROLE_ADMIN', 'ROLE_USER' => 'ROLE_USER'],
                'multiple' => true,
            ])
            ->setMethod('POST')
            ->add('create', SubmitType::class, ['label' => 'créer user'])
            ->getForm();

        $form->handleRequest($request);

        if($request->isMethod('post')){
            if ($form->isSubmitted() && $form->isValid()){
                $success = $this->msg(true);
                $entityManager->persist($newUser);
                $entityManager->flush();
            }else{
                $success = $this->msg(false);
            }
        }

        return $this->render('admin_dashbord/index.html.twig', [
            'user'=> $currentUser,
            'form'=>$form,
            'success'=>$success
        ]);
    }

    private function msg(bool $success, string $userName = null):string{
        if(!$success){
            return 'Quelque chose s\'est mal passé';
        }
        return "l\'utilisateur a été ajouté";
    }
}
