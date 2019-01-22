<?php

namespace App\Controller;

use App\Entity\Courses;
use App\Entity\User;
use App\Form\CoursesType;
use App\Repository\CoursesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/courses")
 */
class CoursesController extends AbstractController
{
    /**
     * @Route("/", name="courses_index", methods={"GET"})
     */
    public function index(CoursesRepository $coursesRepository): Response
    {
        $getAllCourses = $coursesRepository->findAll();
        $getUserCourses = $this->getUser()->getCourses();
        return $this->render('courses/index.html.twig', [
            'allCourses' => $getAllCourses,
            'userCourses' => $getUserCourses,
        ]);
    }

    /**
     * @Route("/register/{id}", name="courses_register", methods={"GET"})
     */
    public function register(Courses $courses): Response{
        $user = $this->getUser();
        $entityManager = $this->getDoctrine()->getManager();
        $user->addCourses($courses);
        $entityManager->persist($courses);
        $entityManager->flush();
        return $this->redirectToRoute('courses_index');
    }
}
