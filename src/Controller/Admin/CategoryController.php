<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route('admin/category', name: 'admin_category_')]
class CategoryController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(CategoryRepository $repository): Response
    {
        $cate = $repository->findAll();
        return $this->render('admin/category/index.html.twig', [
            'categories' => $cate,
        ]);
    }

    #[Route('/new', name: 'new', methods:['GET','POST'])]
    public function new(Request $request,EntityManagerInterface $em)
    {
        $cate=new Category();
        $category=$this->createForm(CategoryType::class,$cate);
        $category->handleRequest($request);

        if($category->isSubmitted() && $category->isValid()){
            $em->persist($category);
            $em->flush();

             $this->addFlash('Sucess','Tu as ajouté une catégorie');
            return $this->redirectToRoute('admin_category_index');
        }
        return $this->render('admin/category/new.html.twig',[
            'formulaire_cate'=> $category
        ]);
    }

    #[Route('/edit/{id}', name: 'edit',methods:['GET','POST'])]
    public function edit(Category $category,EntityManagerInterface $em,Request $request)
    {
        $category=$this->createForm(CategoryType::class,$category);
        $category->handleRequest($request);

        if($category->isSubmitted() && $category->isValid()){
            $em->flush();

            $this->addFlash('Sucess','Tu as modifié une catégorie');
            return $this->redirectToRoute('admin_category_index');
        }

        return $this->render('admin/category/edit.html.twig',[
            'formulaire_edit'=> $category
        ]);
    }

    #[Route('/delete/{id}', name: 'delete',methods:['DELETE'])]
    public function delete(EntityManagerInterface $em,Category $category)
    {
        $em->remove($category);
        $em->flush();

        $this->addFlash('danger','categorie supprimer');
        return $this->redirectToRoute('admin_category_index');
    
    }
}
