<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class DashboardController extends AbstractController
{
    #[Route('/admin', name: 'admin_dashboard_index')]
    public function index(): Response
    {
        return $this->render('dashboard/index.html.twig', [
        ]);
    }
}
