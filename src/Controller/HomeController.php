<?php

namespace App\Controller;

use App\Repository\CourRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param CourRepository $courRepository
     *
     * @return Response
     */
    public function index(CourRepository $courRepository): Response
    {
        $cours = $courRepository->getLastCourses();
        return $this->render('home/index.html.twig', [
            'cours' => $cours,
        ]);
    }
}
