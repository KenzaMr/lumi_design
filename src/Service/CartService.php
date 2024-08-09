<?php

namespace App\Service;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService
{
    public function __construct(private ProductRepository $repository,private RequestStack $requestStack)
    {
    }
    private function getReturn(){
        return $this->requestStack->getSession();
    }
    public function getCart()
    {
        $cart = $this->getReturn()->get('produit', []);
        $dataCart = [];
        foreach ($cart as $id => $quantite) {
            $product = $this->repository->find($id);
            if (!$product) {
                continue;
            }
            $total = $product->getPrice() * $quantite;

            $dataCart[] = [
                'produit' => $product,
                'quantite' => $quantite,
                'total' => $total
            ];
        }
        return $dataCart;
    }
}
