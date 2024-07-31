<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('admin/produit', name: 'admin_produit_')]
class ProductController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ProductRepository $repository, Request $request)
    {
        $produits = $repository->paginateProductOrderByUpdateAt($request->query->getInt('page', 1));
        return $this->render('admin/index.html.twig', [
            'produits' => $produits
        ]);
    }
    #[Route('/create', name: 'new', methods: ['GET', 'POST'])]
    public function new(EntityManagerInterface $em, Request $request)
    {
        $newProduit = new Product();
        $form = $this->createForm(ProductType::class, $newProduit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $em->persist($form);
            $em->flush();

            return $this->redirectToRoute('admin_produit_index');
        }
        return $this->render('admin/new.html.twig', [
            'formulaire_produit' => $form
        ]);
    }
}
