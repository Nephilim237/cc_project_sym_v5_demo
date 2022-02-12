<?php

namespace App\Controller;

use App\Entity\Cour;
use App\Form\CourseFormType;
use App\Repository\CourRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CourseController extends AbstractController
{
    /**
     * @Route("/courses", name="courses")
     * @param Request        $request
     * @param CourRepository $courRepository
     *
     * @return Response
     */
    public function index(Request $request, CourRepository $courRepository): Response
    {
        $page = (int)$request->query->get('page', 1);
        $limit = 36;
        $courses = $courRepository->getPainatedCourses($page, $limit);
        $activeCourses = count($courRepository->findAll());
        $totalPages = ceil($activeCourses / $limit);
        return $this->render('course/index.html.twig', [
            'courses' => $courses,
            'activeCourses' => $activeCourses,
            'page' => $page,
            'totalPages' => $totalPages,
            'limit' => $limit
        ]);
    }

    /**
     * @Route("/course/add", name="course_add")
     * @param Request $request
     *
     * @return Response
     */
    public function courseAdd(Request $request)
    {
        $course = new Cour();
        $form = $this->createForm(CourseFormType::class, $course);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $course
                ->setUser($this->getUser())
                ->setActive(false)
            ;

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($course);
            $manager->flush();
            $this->addFlash('success', "Votre cour est en attente de validation.");
            return $this->redirectToRoute('home');
        }

        return $this->render('course/course_add.html.twig', [
            'form'      =>      $form->createView()
        ]);
    }
}
