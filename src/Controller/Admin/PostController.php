<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use App\Form\PostFormType;
use App\Repository\PostRepository;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    /**
     * @Route("/admin/post", name="post_home")
     * @param PostRepository $postRepository
     *
     * @return Response
     */
    public function index(PostRepository $postRepository): Response
    {
        return $this->render('admin/post/index.html.twig', [
            'posts' => $postRepository->findAll(),
        ]);
    }

    /**
     * @Route("admin/post/add", name="post_add")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function postAdd(Request $request): Response
    {
        $post = new Post();
        $form = $this->createForm(PostFormType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $post
                ->setAuthor($this->getUser())
                ->setActive(false)
            ;
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($post);
            $manager->flush();

            $this->addFlash('success', 'Article en attente de validation.');
            return $this->redirectToRoute('post_home');
        }

        return $this->render('admin/post/post_add.html.twig', [
            'postForm' => $form->createView(),
        ]);

    }

    /**
     * @Route("admin/post/edit", name="post_edit")
     *
     * @param Post    $post
     * @param Request $request
     *
     * @return Response
     */
    public function postEdit(Post $post, Request $request): Response
    {
        $form = $this->createForm(PostFormType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $post
                ->setAuthor($this->getUser())
                ->setActive(false)
            ;
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($post);
            $manager->flush();

            $this->addFlash('success', 'Article en attente de validation.');
            return $this->redirectToRoute('post_home');
        }

        return $this->render('admin/post/post_add.html.twig', [
            'postForm' => $form->createView(),
        ]);

    }
}
