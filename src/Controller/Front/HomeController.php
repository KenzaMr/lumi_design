<?php

namespace App\Controller\Front;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('front/home', name: 'front_home_')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(ProductRepository $repository, Request $request): Response
    {
        $pagination = $repository->paginateProduct($request->query->getInt('page', 1));
        return $this->render(
            'front/home/index.html.twig',
            [
                'produits' => $pagination
            ]
        );
    }
    #[Route('/detail/{id}', name: 'new')]
    public function new($id,ProductRepository $repository)
    {
        $detail=$repository->find($id);
        return $this->render('front/home/detail.html.twig',[
            'produit'=>$detail
        ]);
    }
}
