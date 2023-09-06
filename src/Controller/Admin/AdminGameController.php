<?php

namespace App\Controller\Admin;

use App\Entity\Game;
use App\Form\GameType;
use App\Repository\GameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/game', name: 'app_admin_game')]
class AdminGameController extends AbstractController
{
    #[Route('/', name: '_list')]
    public function listAll(GameRepository $gameRepository): Response
    {
        return $this->render('admin/admin_game/index.html.twig', [
            "games" => $gameRepository->findAll(),
        ]);
    }

    #[Route('/add', name: '_add')]
    #[Route('/modify/{id}', name: '_modify')]
    public function addOrModify(Request $request,
                            EntityManagerInterface $entityManager,
                            GameRepository $gameRepository,
                            SluggerInterface $slugger,
                            int $id = null): Response
    {
        if($id == null) {
            $game = new Game();
        } else {
            $game = $gameRepository->find($id);
        }

        $form = $this->createForm(GameType::class, $game);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $image = $form->get('image')->getData();

            if ($image) {
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $image->guessExtension();

                try {
                    $image->move(
                        $this->getParameter('game_image_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    throw new \Exception("Error while uploading the image");
                }

                $game->setImage($newFilename);
            }

            $entityManager->persist($game);
            $entityManager->flush();

            $this->addFlash(
                'success',
                $id ? 'Game modified' : 'Game added'
            );

            return $this->redirectToRoute('app_admin_game_list');
        }
        return $this->render('admin/admin_game/game_form.html.twig', [
            "form" => $form
        ]);
    }

    #[Route('/delete/{id}', name: '_delete')]
    public function delete(Game $game,
                            EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($game);
        $entityManager->flush();

        $this->addFlash(
            'success',
            'Game deleted'
        );

        return $this->redirectToRoute('app_admin_game_list');
    }
}
