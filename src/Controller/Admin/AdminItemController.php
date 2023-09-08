<?php

namespace App\Controller\Admin;

use App\Entity\Item;
use App\Form\ItemType;
use App\Repository\ItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/item', name: 'app_admin_item')]
class AdminItemController extends AbstractController
{
    #[Route('/', name: '_list')]
    public function listAll(ItemRepository $itemRepository): Response
    {
        return $this->render('admin/admin_item/index.html.twig', [
            "items" => $itemRepository->findAll(),
        ]);
    }

    #[Route('/add', name: '_add')]
    #[Route('/modify/{id}', name: '_modify')]
    public function addOrModify(
                                    Request $request,
                                    EntityManagerInterface $entityManager,
                                    ItemRepository $itemRepository,
                                    int $id = null
                                ): Response {
        if ($id == null) {
            $item = new Item();
        } else {
            $item = $itemRepository->find($id);
        }

        $form = $this->createForm(ItemType::class, $item);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($item);
            $entityManager->flush();

            $this->addFlash(
                'success',
                $id ? 'Item modified' : 'Item added'
            );

            return $this->redirectToRoute('app_admin_item_list');
        }
        return $this->render('admin/admin_item/item_form.html.twig', [
            "form" => $form
        ]);
    }

    #[Route('/delete/{id}', name: '_delete')]
    public function delete(Item $item,
                           EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($item);
        $entityManager->flush();

        $this->addFlash(
            'success',
            'Item deleted'
        );

        return $this->redirectToRoute('app_admin_item_list');
    }
}
