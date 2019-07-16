<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use \Symfony\Component\HttpFoundation\Response;

class MainController extends AbstractController
{
    /**
     * @Route("/main", name="main")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path'    => 'src/Controller/MainController.php',
        ]);
    }

    /**
     * @Route("/todo/{name}", name="todo")
     */
    public function todo(string $name): Response
    {
        return $this->render('main/todo.html.twig', ['name' => $name]);
    }
}
