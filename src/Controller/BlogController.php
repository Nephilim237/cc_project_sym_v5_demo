<?php

namespace App\Controller;

use App\Form\ContactAuthorFormType;
use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
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
     * @param Request            $request
     * @param PostRepository     $postRepository
     * @param CategoryRepository $categoryRepository
     * @param MailerInterface    $mailer
     * @param                    $slug
     *
     * @return Response
     * @throws TransportExceptionInterface
     */
    public function postDetails(Request $request,PostRepository $postRepository, CategoryRepository $categoryRepository, MailerInterface $mailer, $slug)
    {
        $post = $postRepository->findOneBy(['slug' =>  $slug]);
        if (!$post) {
            throw new NotFoundHttpException("L'annonce que vous avez demandé n'existe pas");
        }
        $form = $this->createForm(ContactAuthorFormType::class);
        $contact = $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $senderEmail = $contact->get('email')->getData();
            $email = (new TemplatedEmail())
                ->from($senderEmail)
                ->to($post->getAuthor()->getEmail())
                ->subject("Réaction relative à l'article {$post->getTitle()}")
                ->htmlTemplate('emails/contact_author.html.twig')
                ->context([
                    'post' => $post,
                    'sender' => $senderEmail,
                    'message' => $contact->get('message')->getData(),
                ])
            ;
            $mailer->send($email);
            $this->addFlash('success', "Méssage envoyé avec succès.");
            return $this->redirectToRoute('single', ['slug' => $post->getSlug()]);
//            if ($contact->get('title')->getData() !== $post->getTitle()) {
//                $this->addFlash('danger', "L'article concerné est inexistant.");
//            } else {
//            }
        }

        return $this->render('blog/single.html.twig', [
            'post'   =>     $post,
            'categories' => $categoryRepository->getCategories(12),
            'form' => $form->createView(),
        ]);
    }
}
