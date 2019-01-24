<?php

namespace App\Controller;

use App\Entity\Grades;
use App\Form\GradesType;
use App\Repository\CoursesRepository;
use App\Repository\GradesRepository;
use App\Repository\UserRepository;
use App\Service\CourseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User; 
use App\Entity\Courses;
use App\Service\GradeService;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/grades")
 * @IsGranted("ROLE_USER")
 */
class GradesController extends AbstractController
{
    /**
     * @Route("/", name="grades_index", methods={"GET"})
     * @IsGranted("ROLE_STUDENT")
     */
    public function index(GradesRepository $gradesRepository, GradeService $gradeService): Response
    {
        $allGrades = $gradesRepository->findByStudentId($this->getUser()->getId());
        $average = $gradeService->countAverage($allGrades);

        return $this->render('grades/index.html.twig', [
            'grades' => $gradesRepository->findByStudentId($this->getUser()->getId()),
            'average' => $average
        ]); 
    }

    /**
     * @Route("/new/{idCourse}/{idStudent}", name="grades_new", methods={"GET","POST"})
     * @IsGranted("ROLE_PROFESSOR")
     */
    public function new(Request $request,UserRepository $userRepository,
                        CoursesRepository $coursesRepository,$idCourse, $idStudent): Response
    {
        $grade = new Grades();
        $user = $this->getUser();
        $course = $coursesRepository->find($idCourse)->getUsers();
        $data = [];
        foreach ($course as $key => $value) {
            $data[] = $value;
        }
        if (!in_array($user, $data)) {
            throw new UnauthorizedHttpException("Not authorized to access this webpage");
        }
        $course = $coursesRepository->find($idCourse);
        $user = $userRepository->find($idStudent);
        $form = $this->createForm(GradesType::class, $grade);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $user->addGrades($grade);
            $course->addGrades($grade);
            $entityManager->persist($grade);
            $entityManager->flush();

            return $this->redirectToRoute('courses_index');
        }

        return $this->render('grades/new.html.twig', [
            'grade' => $grade,
            'form' => $form->createView(),
        ]);
    }
}
