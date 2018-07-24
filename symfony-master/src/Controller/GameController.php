<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GameController extends Controller
{
    /**
     * @Route("/game", name="game")
     */
    public function index()
    {

        $em = $this->getDoctrine()->getManager();
        $games = $em->getRepository(User::class)->findAll();




        return $this->render('game/index.html.twig', [
            'controller_name' => 'GameController',
            'games'=>$games
        ]);
    }
}
