<?php

namespace App\Controller;

use App\Form\ContactSiteFormType;
use App\Repository\CourRepository;
use App\Repository\PostRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param CourRepository $courRepository
     *
     * @param PostRepository $postRepository
     *
     * @return Response
     */
    public function index(CourRepository $courRepository, PostRepository $postRepository): Response
    {
        $cours = $courRepository->getLastCourses();
        $posts = $postRepository->findBy(['active' => true], ['createdAt' => 'DESC'], 4);
        return $this->render('home/index.html.twig', [
            'cours'         =>      $cours,
            'posts'         =>      $posts,
        ]);
    }
}
