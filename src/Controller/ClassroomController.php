<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Classroom;

use App\Form\ClassoomType;

class ClassroomController extends AbstractController
{
    /**
     * @Route("/classroom", name="classroom")
     */
    public function index(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository(Classroom::class);
        $classrooms = $repository->findAll();
        return $this->render('classroom/index.html.twig', [
            'controller_name' => 'ClassroomController',
            'classrooms' => $classrooms
        ]);
    }

    /**
     * @Route("/add-classroom", name="add_classroom")
     */
    public function add(Request $request): Response
    {
        $classroom = new Classroom();
        $form = $this->createForm(ClassoomType::class,$classroom);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($classroom);
            $entityManager->flush();
            return $this->redirectToRoute("classroom");
        }

        return $this->render('classroom/add.html.twig', [
            'form_title' => 'Add classroom',
            'form_classroom' => $form->createView(),
        ]);
    }
}
