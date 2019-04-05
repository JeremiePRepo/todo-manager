<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PagesController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->render('pages/index.html.twig', [
            'controller_name' => 'PagesController',
        ]);
    }

    /**
     * @Route("/todolist", name="todolist")
     */
    public function todolist()
    {
        return $this->render('pages/todolist.html.twig');
    }

    /**
     * @Route("/todolist/create", name="create_task")
     */
    public function create(Request $request)
    {
        // Prépare la création d'un nouvel article
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Si le formulaire a été envoyé
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($task);
            $manager->flush();
            $this->addFlash('info', 'La tâche a bien été ajouté');

            return $this->redirectToRoute('todolist');
        }

        return $this->render('pages/tasks/create.html.twig', array('taskForm' => $form->createView()));
    }
}
