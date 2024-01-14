<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\UserConnection;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function index(): Response
    {
        $user = new UserConnection();
        $form = $this->createFormBuilder($user)
            ->add('username', TextType::class,  ['label' => 'Email'])
            ->add('password', PasswordType::class)
            ->add('save', SubmitType::class)
            ->setMethod('POST')
            ->setAction('app_login_check')
            ->getForm();

        return $this->render('login/index.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/login-check', name: 'app_login_check')]
    public function loginCheck(){
            dump('test');
            die();
    }
}
