<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\CategoryType;
use Symfony\Component\HttpFoundation\Request;

#[Route('/category', name: 'category_')]
class CategoryController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();


        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    //Attention : Comme la route est de la forme /category/new, 
    //veille à bien la placer au dessus de la méthode show(). 
    //En effet, si tu la places après, le routeur de Symfony s'arrêtant à
    // la première route qui "match", il va penser que tu veux afficher la catégorie
    // qui a pour name "new" et tu auras une erreur 404.
    #[Route('/new', name: 'new')]
    public function new(Request $request, CategoryRepository $categoryRepository): Response
    {
        $category = new Category();

        // Create the form, linked with $category
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        // Was the form submitted ?
        if ($form->isSubmitted()) {
            $categoryRepository->save($category, true);

            // Redirect to categories list
            return $this->redirectToRoute('category_index');
        }

        // Render the form (best practice)
        return $this->renderForm('category/new.html.twig', [
            'form' => $form,
        ]);

        // Alternative
        // return $this->render('category/new.html.twig', [
        //   'form' => $form->createView(),
        // ]);
    }

    #[Route('/{categoryName}', methods: ['GET'], name: 'show')]
    public function show(string $categoryName, CategoryRepository $categoryRepository, ProgramRepository $programRepository): Response
    {

        $category = $categoryRepository->findByName($categoryName);

        if (!$category) {
            throw $this->createNotFoundException('The category does not exist');
            // the above is just a shortcut for:
            // throw new NotFoundHttpException('The product does not exist');
        }
        $programByCategory = $programRepository->findByCategory($category, ['id' => 'DESC'], 3, 0);

        return $this->render('category/show.html.twig', [
            'programs' => $programByCategory,
            'categoryName' => $categoryName,
        ]);
    }
}
