<?php

namespace App\Controller;

use App\Entity\Todo;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use \Symfony\Component\HttpFoundation\Response;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index()
    {
        $todo = new  Todo;
        $em = $this->getDoctrine()->getManager();

        $todo->setStatus('В процессе')
            ->setPriority('Высокий')
            ->setName('Первый todo')
            ->setDateCreation(new \DateTime());

        $em->persist($todo);
        $em->flush();

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
