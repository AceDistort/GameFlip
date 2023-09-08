<?php

namespace App\Controller;

use App\Repository\CityRepository;
use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/game', name: 'app_game')]
class GameController extends AbstractController
{

    #[Route('/', name: '_list')]
    public function list(GameRepository $gameRepository, CityRepository $cityRepository, Request $request): Response
    {

        $cityId = $request->query->get('cityId');

        if ($cityId) {
            $selectedCity = $cityRepository->find($cityId);
        } elseif ($this->getUser() && $this->getUser()->getCity() ) {
            // select the city of the user
            $selectedCity = $this->getUser()->getCity();
        } else {
            // select the first city
            $selectedCity = $cityRepository->findBy([], [], 1)[0];
        };

        return $this->render('game/index.html.twig', [
            "games" => $gameRepository->findGamesByCity($selectedCity->getId()),
            "cities" => $cityRepository->findAll(),
            "selectedCity" => $selectedCity,
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
