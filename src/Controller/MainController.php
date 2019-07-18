<?php

namespace App\Controller;

use App\Entity\Todo;
use App\Form\TodoType;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use \Symfony\Component\HttpFoundation\Response;
use \Symfony\Component\HttpFoundation\JsonResponse;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(): JsonResponse
    {
        $todo = new  Todo;
        $em = $this->getDoctrine()->getManager();

        $todo->setName('Второй todo')
            ->setStatus('Завершён')
            ->setPriority('Низкий')
            ->setDateCreation(new DateTime);

        $em->persist($todo);
        $em->flush();

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path'    => 'src/Controller/MainController.php',
        ]);
    }

    /**
     * @Route("/todo/{name}", name="todo")
     * @param string $name
     * @return Response
     */
    public function todo(string $name): Response
    {
        $form = $this->createForm(TodoType::class);

        return $this->render('main/todo.html.twig', ['name' => $name, 'form' => $form->createView()]);
    }

    /**
     * @Route("/details", name="todo_details")
     */
    public function details(): Response
    {
        $todo = $this->getDoctrine()->getRepository(Todo::class)->findByName('Первый');
        if (!$todo) {
            throw $this->createNotFoundException('Ничего не найдено.');
        }
        return new Response(var_dump($todo));
    }

    /**
     * @Route("/updatetodo/{id}", name="update_todo")
     * @param Todo|null $todo
     * @return Response
     */
    public function updateTodo(?Todo $todo): Response
    {
        if (!$todo) {
            throw $this->createNotFoundException('Ничего не найдено.');
        }
        $em = $this->getDoctrine()->getManager();
        $todo->setPriority('Средний');
        $em->flush();
        return new Response($todo->getPriority());
    }

    /**
     * @Route("/deletetodo/{id}", name="delete_todo")
     * @param Todo $todo
     * @return Response
     */
    public function deteteTodo(?Todo $todo): Response
    {
        if (!$todo) {
            throw $this->createNotFoundException('Ничего не найдено.');
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($todo);
        $em->flush();
        return new Response('Запись ' . $todo->getName() .' удалена!');
    }
}
