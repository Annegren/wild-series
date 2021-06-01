<?php
// src/Controller/CategoryController.php
namespace App\Controller;

use App\Entity\Category;
use App\Entity\Program;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\CategoryType;
use Symfony\Component\HttpFoundation\Request;

/**
* @Route("/categories", name="category_")
*/
class CategoryController extends AbstractController
{
     /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();

        return $this->render('category/index.html.twig', [
            'categories' => $categories,
         ]);
    }

    /**
     * The controller for the category add form
     *
     * @Route("/new", name="new")
     */
    public function new(Request $request) : Response
    {
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($category);

            $entityManager->flush();

            return $this->redirectToRoute('category_index');
        }
        return $this->render('category/new.html.twig', ["form" => $form->createView()]);
    }


     /**
     * @Route ("/{categoryName}", methods={"GET"}, name="show")
     */
     public function show(string $categoryName): Response
    {
        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findOneBy(['name' => $categoryName]);

        if (!$categories) {
            throw $this->createNotFoundException(
                'Sorry we have not this category in our program'
            );
        }

        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findBy(['category' => $categories->getId()], ['id' => 'DESC'],3);

        return $this->render('category/show.html.twig', [
            'programs' => $programs,
            'categories' => $categories,

        ]);
    }
}