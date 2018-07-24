<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ArticleController extends Controller
{
    /**
     * @Route("/article", name="article")
     */
    public function index(Request $request, ArticleRepository $articleRepository)
    {

        $article = new Article();
        $form = $this->createForm(ArticleType::class,$article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();
        }

        $articles = $articleRepository->findAll();

        return $this->render('article/index.html.twig', array(

            'form'=>$form->createView(),
            'controller_name'=>"presley",
            'article'=>$articles
        )
        );
    }
}
