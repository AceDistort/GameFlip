<?php

namespace App\Controller\Admin;

use App\Entity\City;
use App\Form\CityType;
use App\Repository\CityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/city', name: 'app_admin_city')]
class AdminCityController extends AbstractController
{
    #[Route('/', name: '_list')]
    public function listAll(CityRepository $cityRepository): Response
    {
        return $this->render('admin/admin_city/index.html.twig', [
            "cities" => $cityRepository->findAll(),
        ]);
    }

    #[Route('/add', name: '_add')]
    #[Route('/modify/{id}', name: '_modify')]
    public function addOrModify(Request                $request,
                                EntityManagerInterface $entityManager,
                                CityRepository         $cityRepository,
                                int                    $id = null): Response
    {
        if($id == null) {
            $city = new City();
        } else {
            $city = $cityRepository->find($id);
        }

        $form = $this->createForm(CityType::class, $city);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($city);
            $entityManager->flush();

            $this->addFlash(
                'success',
                $id ? 'City modified' : 'City added'
            );

            return $this->redirectToRoute('app_admin_city_list');
        }
        return $this->render('admin/admin_city/city_form.html.twig', [
            "form" => $form
        ]);
    }

    #[Route('/delete/{id}', name: '_delete')]
    public function delete(City $city,
                           EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($city);
        $entityManager->flush();

        $this->addFlash(
            'success',
            'City deleted'
        );

        return $this->redirectToRoute('app_admin_city_list');
    }
}
