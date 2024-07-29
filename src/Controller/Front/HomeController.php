<?php

namespace App\Controller\Front;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('front/home', name: 'front_home_')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ProductRepository $repository): Response
    {
        $produits=$repository->findAll();
        return $this->render('front/home/index.html.twig',[
            'poduits'=>$produits
        ]
        );
    }
}
