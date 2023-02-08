<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentNotationController extends AbstractController
{
    #[Route('/comment/notation', name: 'app_comment_notation')]
    public function index(): Response
    {
        return $this->render('comment_notation/index.html.twig', [
            'controller_name' => 'CommentNotationController',
        ]);
    }
}
