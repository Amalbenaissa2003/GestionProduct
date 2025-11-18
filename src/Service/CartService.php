<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\RequestStack;

class CartService
{
    private $session;

    public function __construct(RequestStack $requestStack)
    {
        $this->session = $requestStack->getSession();
    }

    public function add(int $productId)
{
    $cart = $this->session->get('cart', []);

    if (!isset($cart[$productId])) {
        $cart[$productId] = 1;
    } else {
        $cart[$productId]++;
    }

    $this->session->set('cart', $cart);
}

public function remove(int $productId)
{
    $cart = $this->session->get('cart', []);
    unset($cart[$productId]);
    $this->session->set('cart', $cart);
}




    public function getCart()
    {
        return $this->session->get('cart', []);
    }

    public function clear()
    {
        $this->session->remove('cart');
    }

    public function count()
    {
        return count($this->session->get('cart', []));
    }
}
