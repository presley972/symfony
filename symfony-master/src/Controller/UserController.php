<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class UserController extends Controller
{
    /**
     * @Route("/user", name="user")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request, UserRepository $userRepository)
    {
        $user = new User();
        $form = $this->createForm(UserType::class,$user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
        }

        $games = $userRepository->findAll();

        return $this->render('user/index.html.twig', array(

                'form'=>$form->createView(),
                'controller_name'=>"presley",
                'games'=>$games
            )

        );
    }

    /**
     * @Route("/user/{byFirstname}", name="user_firstname")
     * @ParamConverter("user", options={"mapping"={"byFirstname"="firstname"}})
     */
    public function firstname(Request $request, UserRepository $userRepository, User $user){

        return $this->render('user/user.html.twig',[
                'user'=> $user,
        ]

        );

    }

}
