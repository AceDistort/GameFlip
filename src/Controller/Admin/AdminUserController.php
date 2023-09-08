<?php

namespace App\Controller\Admin;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminUserController extends AbstractController
{
    #[Route('/admin/user', name: 'app_admin_user_list')]
    public function lister(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();

        // it's not a problem to pass passwords to the view because they are not send to client side (we are not using API)

        return $this->render('admin/admin_user/index.html.twig', [
            'users' => $users,
        ]);
    }
}
