<?php

namespace App\Controller\Front;

use App\Entity\Category;
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
    #[Route('/detail/{slug}', name: 'show',methods:['GET'])]
    public function show(string $slug, ProductRepository $repository)
    {
        $product=$repository->findWithCategory($slug);
        return $this->render('front/home/show.html.twig',[
            'produit'=>$product
        ]);
    }
    #[Route('/conditions-site', name: 'terms')]
    public function terms(){
        return $this->render('front/home/terms.html.twig');
    }

}
