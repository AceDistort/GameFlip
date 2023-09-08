<?php

namespace App\Controller;

use App\Entity\Item;
use App\Form\ItemType;
use App\Repository\CityRepository;
use App\Repository\GameRepository;
use App\Repository\ItemRepository;
use Doctrine\ORM\EntityManagerInterface;
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
        $available = $request->query->get('available');

        if ($cityId) {
            $selectedCity = $cityRepository->find($cityId);
        } elseif ($this->getUser() && $this->getUser()->getCity() ) {
            // select the city of the user
            $selectedCity = $this->getUser()->getCity();
        } else {
            // select the first city
            $selectedCity = $cityRepository->findBy([], [], 1)[0];
        };

        switch ($available) {
            case 'true':
                $available = true;
                break;
            case 'false':
                $available = false;
                break;
            default:
                $available = null;
        }

        return $this->render('game/index.html.twig', [
            "games" => $gameRepository->findAvailableGamesByCity($selectedCity->getId(), $available),
            "cities" => $cityRepository->findAll(),
            "selectedCity" => $selectedCity,
            "available" => $available,
        ]);
    }

    #[Route('/my-games', name: '_my_games')]
    public function myGames(ItemRepository $itemRepository): Response
    {

        $userId = $this->getUser()->getId();

        if (!$userId) {
            throw $this->createAccessDeniedException();
        }

        return $this->render('game/my_games.html.twig', [
            "items" => $itemRepository->findItemsByUser($userId),
        ]);
    }

    #[Route('/my-games/add', name: '_add')]
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $item = new Item();

        $form = $this->createForm(ItemType::class, $item);

        $form->handleRequest($request);

        // if the form is submitted and valid
        if ($form->isSubmitted() && $form->isValid()) {

            $item->setUser($this->getUser());

            $entityManager->persist($item);
            $entityManager->flush();

            return $this->redirectToRoute('app_game_my_games');
        }

        return $this->render('game/game_add.html.twig', [
            "form" => $form,
        ]);
    }

    #[Route('/{id}', name: '_details')]
    public function details(GameRepository $gameRepository, int $id): Response
    {
        return $this->render('game/game_details.html.twig', [
            "game" => $gameRepository->find($id),
        ]);
    }

    #[Route('/my-games/delete/{id}', name: '_delete')]
    public function delete(ItemRepository $itemRepository, EntityManagerInterface $entityManager, int $id): Response
    {

        $item = $itemRepository->find($id);

        if ($item->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        $entityManager->remove($item);
        $entityManager->flush();

        return $this->redirectToRoute('app_game_my_games');
    }

}
