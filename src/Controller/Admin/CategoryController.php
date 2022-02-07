<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/admin/category", name="category_home")
     * @param CategoryRepository $categoryRepository
     *
     * @return Response
     */
    public function index(CategoryRepository $categoryRepository): Response
    {
        return $this->render('admin/category/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/category_add", name="category_add")
     * @param Request $request
     *
     * @return Response
     */
    public function categoryAdd(Request $request): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($category);
            $manager->flush();

            $this->addFlash('success', 'Catégorie ajoutée avec succès.');
            return $this->redirectToRoute('category_home');
        }

        return $this->render('admin/category/category_add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/category_edit/{id}", name="category_edit")
     * @param Category $category
     * @param Request  $request
     *
     * @return Response
     */
    public function categoryEdit(Category $category,Request $request): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($category);
            $manager->flush();

            $this->addFlash('success', 'Catégorie ajoutée avec succès.');
            return $this->redirectToRoute('category_home');
        }

        return $this->render('admin/category/category_add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
