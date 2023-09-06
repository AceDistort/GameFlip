<?php

namespace App\Controller;

use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/game', name: 'app_game')]
class GameController extends AbstractController
{

    #[Route('/', name: '_list')]
    public function list(GameRepository $gameRepository): Response
    {
        return $this->render('game/index.html.twig', [
            "games" => $gameRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: '_details')]
    public function details(GameRepository $gameRepository, int $id): Response
    {
        return $this->render('game/game_details.html.twig', [
            "game" => $gameRepository->find($id),
        ]);
    }
}
