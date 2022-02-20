<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     * @param PostRepository     $postRepository
     *
     * @param CategoryRepository $categoryRepository
     *
     * @return Response
     */
    public function index(PostRepository $postRepository, CategoryRepository $categoryRepository): Response
    {
        return $this->render('blog/index.html.twig', [
            'posts' => $postRepository->findBy(['active' => true], ['createdAt' => 'desc']),
            'categories' => $categoryRepository->getCategories(12),
        ]);
    }

    /**
     * @Route("/blog/{slug}", name="single")
     * @param PostRepository     $postRepository
     * @param CategoryRepository $categoryRepository
     * @param                    $slug
     *
     * @return Response
     */
    public function postDetails(PostRepository $postRepository, CategoryRepository $categoryRepository, $slug)
    {
        $post = $postRepository->findOneBy(['slug' =>  $slug]);
        if (!$post) {
            throw new NotFoundHttpException("L'annonce que vous avez demandé n'existe pas");
        }
        return $this->render('blog/single.html.twig', [
            'post'   =>     $post,
            'categories' => $categoryRepository->getCategories(12),
        ]);
    }
}
