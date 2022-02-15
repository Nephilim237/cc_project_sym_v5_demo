<?php

namespace App\Controller\Admin;

use App\Entity\Image;
use App\Entity\Post;
use App\Form\PostFormType;
use App\Repository\PostRepository;
use phpDocumentor\Reflection\Types\This;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{

    /**
     * @var false|string
     */
    private $day;

    public function __construct()
    {
        $this->day = date('Ymd');
    }

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
     * Fonctionnalité reservée à tous les admin
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
            $this->getImages($form, $post);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($post);
            $manager->flush();

            $this->addFlash('success', "L'article {$form->get('title')->getData()} est en attente de validation.");
            return $this->redirectToRoute('post_home');
        }

        return $this->render('admin/post/post_add.html.twig', [
            'postForm' => $form->createView(),
        ]);

    }

    /**
     * Fonctionnalité reservée à tous les administrateurs
     * @Route("admin/post/edit/{id}", name="post_edit")
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
            $this->getImages($form, $post);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($post);
            $manager->flush();

            $this->addFlash('success', "L'article {$form->get('title')->getData()} a bien été modifié et est de nouveau en attente de validation.");
            return $this->redirectToRoute('post_home');
        }

        return $this->render('admin/post/post_edit.html.twig', [
            'postForm'  =>  $form->createView(),
            'post'      =>  $post
        ]);

    }

    /**
     * Fonctionnalité reservée strictement aux supers admins
     * @Route("admin/post/activate/{id}", "activate_post")
     * @param Post $post
     *
     * @return Response
     */
    public function activate(Post $post) {
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN', null, 'Accès non autorisé');
        $post->setActive($post->getActive() ? false : true);
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($post);
        $manager->flush();

        return new Response('true');
    }

    /**
     * Fonctionnalité reservée strictement aux supers admins
     * @Route("admin/post/delete/{id}", "delete_post")
     * @param Post $post
     *
     * @return RedirectResponse
     */
    public function delete(Post $post)
    {
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN', null, 'Accès non autorisé');
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($post);
        $manager->flush();
        $this->addFlash('success', 'Article supprimé avec succès.');
        return $this->redirectToRoute('post_home');
    }

    /**
     * Permet de supprimer les images de facon dynamique dans un post.
     * On intérrogera la route de suppression en AJAX
     * Seule la méthode DELETE est admise
     * @Route("admin/drop/image/{id}", name="post_image_drop", methods={"DELETE"})
     * @param Image   $image Entité qui gère l'ajout et la suppression des images
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function dropImage(Image $image, Request $request) {
        $data = json_decode($request->getContent(), true);
        if ($this->isCsrfTokenValid('delete'.$image->getId(), $data['_token'])){
            unlink($this->getParameter('posts_images_directory'). '/'. $image->getName());
            $em = $this->getDoctrine()->getManager();
            $em->remove($image);
            $em->flush();

            return new JsonResponse(['success' => 1]);
        } else {
            return new JsonResponse(['error' => 'Token invalide'], 400);
        }
    }

    /**
     * Permet d'extraire les images depuis le champ image d'un formulaire
     * Ce champ peut contenir plusieurs images
     * Les images sont ensuite renommées et déplacées dans le dossier des images reservées aux post
     * Chaque image porte la date et l'heure (au format AAAAMMJJhhmmss) à laquelle elle est ajoutée
     * Les images sont rangées dans des dossiers en fonctionda la date du jour
     * @param FormInterface $form  Formulaire depuis lequel on récupère les images
     * @param Post $post L'entité sur laquelle le formulaire est construit
     * Aucune valeur de retour n'est renvoyée
     */
    private function getImages(FormInterface $form, Post $post) {
        $images = $form->get('images')->getData();
        foreach ($images as $image) {
            $file = date('YmdHis') .'_'. $image->getClientOriginalName();
            $image->move(
                $this->getParameter('posts_images_directory') . "/{$this->day}/",
                $file
            );

            $img = new Image();
            $img->setName("{$this->day}/" . $file);
            $post->addImage($img);
        }
    }
}
