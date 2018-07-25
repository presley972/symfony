<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\LoginUserType;
use App\Form\RegisterUserType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{
    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        $form = $this->createForm(RegisterUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('security/index.html.twig', [
            'controller_name' => 'SecurityController',
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils){

        $user = new User();
        $form = $this->createForm(LoginUserType::class, $user);
        if ($form->isSubmitted() && $form->isValid()){
            return $this->redirectToRoute('article');
        }

        return $this->render('security/login.html.twig',[
            'error' => $authenticationUtils ->getLastAuthenticationError(),
            'form' => $form->createView()
        ]);

    }/**
     * @Route("/admin", name="admin")
     */
    public function admin(UserRepository $userRepository)
    {

       $users = $userRepository->findAll();
        return $this->render('security/admin.html.twig', [
            'users' => $users
        ]);

    }
}
