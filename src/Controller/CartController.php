<?php

namespace App\Controller;

use App\Service\CartService;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cart')]
class CartController extends AbstractController
{
       #[Route('/', name: 'app_cart')]
public function index(CartService $cartService, ProductRepository $productRepo): Response
{
    $cart = $cartService->getCart();
    $cartData = [];

    foreach ($cart as $id => $qty) {
        $product = $productRepo->find($id);
        if ($product) {
            $cartData[] = [
                'product' => $product,
                'quantity' => $qty,
                'subtotal' => $product->getPrice() * $qty,
            ];
        }
    }

    return $this->render('cart/index.html.twig', [
        'cart' => $cartData,
        'total' => array_sum(array_column($cartData, 'subtotal')),
    ]);
}

        #[Route('/add/{id}', name: 'app_cart_add')]
        public function add(int $id, CartService $cartService): Response
        {
            $cartService->add($id);

            $this->addFlash('success', 'Product added to cart.');

            return $this->redirectToRoute('app_cart');
        }

    #[Route('/validate', name: 'app_cart_validate')]
    public function validate(CartService $cartService): Response
    {
        // If user is NOT logged in
        if (!$this->getUser()) {
            $this->addFlash('warning', 'You must log in to validate your cart.');

            return $this->redirectToRoute('app_login');
        }

        // If logged in, validate order
        $cartService->clear();

        $this->addFlash('success', 'Cart validated, your order has been placed.');

        return $this->redirectToRoute('app_cart');
    }

    #[Route('/remove/{id}', name: 'app_cart_remove')]
public function remove(int $id, CartService $cartService): Response
{
    $cartService->remove($id);
    $this->addFlash('warning', 'Product removed from cart.');
    return $this->redirectToRoute('app_cart');
}
}
