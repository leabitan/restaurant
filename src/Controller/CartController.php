<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Cart;
use App\Form\CartType;
use App\Repository\CartRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/cart', name: 'cart_')]
class CartController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(SessionInterface $session, ProductRepository $productsRepository)
    {
        $cart = $session->get('cart', []);

        // On initialise des variables
        $data = [];
        $total = 0;

        foreach ($cart as $id => $quantity) {
            $product = $productsRepository->find($id);

            $data[] = [
                'product' => $product,
                'quantity' => $quantity
            ];
            $total += $product->getPrice() * $quantity;
        }
        //On redirige vers la page du panier
        return $this->render('cart/index.html.twig', compact('data', 'total'));
    }


    #[Route('/add/{id}', name: 'add')]
    public function add(Product $product, SessionInterface $session)
    {
        //On récupère l'id du produit
        $id = $product->getId();

        // On récupère le cart existant
        $cart = $session->get('cart', []);

        // On ajoute le produit dans le cart s'il n'y est pas encore
        // Sinon on incrémente sa quantité
        if (empty($cart[$id])) {
            $cart[$id] = 1;
        } else {
            $cart[$id]++;
        }

        $session->set('cart', $cart);

        //On redirige vers la page du cart
        return $this->redirectToRoute('app_view_product');
    }

    #[Route('/remove/{id}', name: 'remove')]
    public function remove(Product $product, SessionInterface $session)
    {
        //On récupère l'id du produit
        $id = $product->getId();

        // On récupère le cart existant
        $cart = $session->get('cart', []);

        // On retire le produit du cart s'il n'y a qu'1 exemplaire
        // Sinon on décrémente sa quantité
        if (!empty($cart[$id])) {
            if ($cart[$id] > 1) {
                $cart[$id]--;
            } else {
                unset($cart[$id]);
            }
        }

        $session->set('cart', $cart);

        //On redirige vers la page du cart
        return $this->redirectToRoute('cart_index');
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete(Product $product, SessionInterface $session)
    {
        //On récupère l'id du produit
        $id = $product->getId();

        // On récupère le cart existant
        $cart = $session->get('cart', []);

        if (!empty($cart[$id])) {
            unset($cart[$id]);
        }

        $session->set('cart', $cart);

        //On redirige vers la page du cart
        return $this->redirectToRoute('cart_index');
    }

    #[Route('/empty', name: 'empty')]
    public function empty(SessionInterface $session)
    {
        $session->remove('cart');

        return $this->redirectToRoute('cart_index');
    }
}
