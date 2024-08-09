<?php

namespace App\Controller\Front;

use App\Repository\ProductRepository;
use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/panier', name: 'front_cart_')]
class CartController extends AbstractController
{
    #[Route('/', name: 'index',methods:['GET'])]
    public function index(CartService $cartService): Response
    {
       $dataCart= $cartService->getCart();
        return $this->render('front/cart/index.html.twig', [
            'dataCart' => $dataCart
        ]);
    }
    #[Route('/ajouter/{id}', name: 'add', methods: ['GET'])]
    public function add($id, SessionInterface $session)
    {
        $cart = $session->get('produit', []);
        if (!isset($cart[$id])) {
            $cart[$id] = 1;
        } else {
            $cart[$id]++;
        }
        $session->set('produit', $cart);

        return $this->redirectToRoute('front_cart_index');
    }
    #[Route('/diminuer/{id}', name: 'decrease', methods: ['GET'])]
    public function decrease($id, SessionInterface $session)
    {
        $cart = $session->get('produit', []);
        if (isset($cart[$id])) {
            if ($cart[$id] > 1) {
                $cart[$id] = $cart[$id] - 1;
            } else {
                unset($cart[$id]);
            }
        }
        $session->set('produit', $cart);

        return $this->redirectToRoute('front_cart_index');
    }
    #[Route('/supprimer/{id}', name: 'delete', methods: ['GET'])]
    public function delete($id, SessionInterface $session)
    {
        $cart = $session->get('produit', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
        }
        $session->set('produit', $cart);

        return $this->redirectToRoute('front_cart_index');
    }
    #[Route('/vider', name: 'empty', methods: ['GET'])]
    public function empty(SessionInterface $session)
    {
        $session->remove('produit');
        return $this->redirectToRoute('front_cart_index');

    }
}
