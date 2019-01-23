<?php

namespace App\Controller;

use App\Entity\Grades;
use App\Form\GradesType;
use App\Repository\CoursesRepository;
use App\Repository\GradesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User; 
use App\Entity\Courses;

/**
 * @Route("/grades")
 */
class GradesController extends AbstractController
{
    /**
     * @Route("/", name="grades_index", methods={"GET"})
     */
    public function index(GradesRepository $gradesRepository): Response
    {
        
        $allGrades = $gradesRepository->findByStudentId($this->getUser()->getId());
        $sum = array_reduce($allGrades, function($carry, $item) {
            $carry += $item->getGrade();
            return $carry;
            var_dump($carry);
        }, 0);
        $average = $sum/count($allGrades);


        return $this->render('grades/index.html.twig', [
            'grades' => $gradesRepository->findByStudentId($this->getUser()->getId()),
            'average' => $average
        ]);
        //$this->getUser()->getGrades();
       // $this->getUser()->getCourses()->getGrades();      
    
    }


    /**
     * @Route("/new/{id}", name="grades_new", methods={"GET","POST"})
     */
    public function new(CoursesRepository $coursesRepository,Request $request, $id): Response
    {
        $grade = new Grades();
        $course = $coursesRepository->find($id);
        $users = [];
        foreach ($course->getUsers() as $value) {
            $users[] = $value->getUsername();
        }
        $form = $this->createForm(GradesType::class, $grade);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($grade);
            $entityManager->flush();

            return $this->redirectToRoute('grades_index');
        }

        return $this->render('grades/new.html.twig', [
            'grade' => $grade,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="grades_show", methods={"GET"})
     */
    public function show(Grades $grade): Response
    {
        return $this->render('grades/show.html.twig', [
            'grade' => $grade,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="grades_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Grades $grade): Response
    {
        $form = $this->createForm(GradesType::class, $grade);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('grades_index', [
                'id' => $grade->getId(),
            ]);
        }

        return $this->render('grades/edit.html.twig', [
            'grade' => $grade,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="grades_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Grades $grade): Response
    {
        if ($this->isCsrfTokenValid('delete'.$grade->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($grade);
            $entityManager->flush();
        }

        return $this->redirectToRoute('grades_index');
    }
}
