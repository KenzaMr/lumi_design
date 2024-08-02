<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route('admin/produit', name: 'admin_produit_')]
class ProductController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ProductRepository $repository, Request $request)
    {
        $produits = $repository->paginateProductOrderByUpdateAt($request->query->getInt('page', 1));
        return $this->render('admin/product/index.html.twig', [
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
        return $this->render('admin/product/new.html.twig', [
            'formulaire_produit' => $form
        ]);
    }

    #[Route('/detail/{slug}', name: 'show', methods: ['GET'], requirements: ['slug' => Requirement::ASCII_SLUG])]
    public function show(?Product $product)
    {
        return $this->render('admin/product/show.html.twig', [
            'produit' => $product
        ]);
    }

    #[Route('/update/{slug}', name: 'update', methods: ['GET', 'POST'], requirements: ['slug' => Requirement::ASCII_SLUG])]
    public function update(Product $product, Request $request, EntityManagerInterface $em)
    {
        $fiche = $this->createForm(ProductType::class, $product);
        $fiche->handleRequest($request);

        if ($fiche->isSubmitted() && $fiche->isValid()) {
            $em->flush();

            return $this->redirectToRoute('admin_produit_index');
        }
        return $this->render('admin/product/update.html.twig', [
            'formulaire_modif' => $fiche
        ]);
    }

    #[Route('/remove/{id}', name: 'remove', methods: ['DELETE'], requirements: ['id' => Requirement::DIGITS])]
    public function remove(Product $product,  EntityManagerInterface $em)
    {
        $em->remove($product);
        $em->flush();

        $this->addFlash('danger','produit supprimer');
        return $this->redirectToRoute('admin_produit_index');
    }
}
