<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/category', name: 'app_admin_category')]
class AdminCategoryController extends AbstractController
{
    #[Route('/', name: '_list')]
    public function listAll(CategoryRepository $categoryRepository): Response
    {
        return $this->render('admin/admin_category/index.html.twig', [
            "categories" => $categoryRepository->findAll(),
        ]);
    }

    #[Route('/add', name: '_add')]
    #[Route('/modify/{id}', name: '_modify')]
    public function addOrModify(Request $request,
                            EntityManagerInterface $entityManager,
                            CategoryRepository $categoryRepository,
                            int $id = null): Response
    {
        if($id == null) {
            $category = new Category();
        } else {
            $category = $categoryRepository->find($id);
        }

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        // if the form is submitted and valid
        if($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($category);
            $entityManager->flush();

            $this->addFlash(
                'success',
                $id ? 'Category modified' : 'Category added'
            );

            return $this->redirectToRoute('app_admin_category_list');
        }
        return $this->render('admin/admin_category/category_form.html.twig', [
            "form" => $form
        ]);
    }

    #[Route('/delete/{id}', name: '_delete')]
    public function delete(Category $category,
                            EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($category);
        $entityManager->flush();

        $this->addFlash(
            'success',
            'Category deleted'
        );

        return $this->redirectToRoute('app_admin_category_list');
    }
}
