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
     * @Route("/add-classroom", name="add-classroom")
     */
    public function add(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository(Classroom::class);
        $id =  $request->query->get('id');
        
        $classroom = new Classroom();
        $obj = $repository->findOneBy([
            'id' => $request->query->get('id')
        ]);
        if($obj){
            $classroom = $obj;    
        }

        $form = $this->createForm(ClassoomType::class,$classroom, array(
            'method' => 'PUT', 
        ));
        $form->handleRequest($request);
        

        if ($form->isSubmitted() && $form->isValid()) {
            //$entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($classroom);
            $entityManager->flush();
            return $this->redirectToRoute("classroom");
        }

        return $this->render('classroom/add.html.twig', [
            'form_title' => 'Add classroom',
            'form_classroom' => $form->createView(),
        ]);
    }

    /**
     * @Route("/view-classroom", name="view-classroom")
     */
    public function view(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository(Classroom::class);
        $classroom = $repository->findOneBy([
            'id' => $request->query->get('id')
        ]);
        return $this->render('classroom/view.html.twig', [
            'controller_name' => 'ClassroomController',
            'form_title' => 'View classroom',
            'classroom' => $classroom
        ]);
    }


    /**
     * @Route("/delete-classroom", name="delete-classroom")
     */
    public function delete(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository(Classroom::class);
        $classroom = $repository->findOneBy([
            'id' => $request->query->get('id')
        ]);
        $entityManager->remove($classroom);
        $entityManager->flush();
        return $this->redirectToRoute("classroom");
    }
}
