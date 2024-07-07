<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Orders;
use App\Entity\OrdersDetails;
use App\Repository\UserRepository;
use App\Repository\OrdersRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



#[Route('/commandes', name: 'app_orders_')]
class OrdersController extends AbstractController
{
    #[Route('/ajout', name: 'add')]



    public function add(SessionInterface $session, ProductRepository $productRepository, EntityManagerInterface $em): Response
    {

        $this->denyAccessUnlessGranted('ROLE_USER');
        $cart = $session->get('cart', []);
        if ($cart === []) {
            $this->addFlash('message', 'Votre panier est vide');
            // return $this->redirectToRoute('app_home');
        }
        // Initialisation des variables pour stocker la somme des quantités et des prix
        $totalQuantity = 0;
        $totalPrice = 0;
        //Le panier n'est pas vide, on  créait la commande
        $order = new Orders();

        // Association de l'utilisateur actuellement connecté à la commande
        $user = $this->getUser();
        if (!$user) {
            throw $this->createAccessDeniedException('Utilisateur non trouvé.');
        }
        $order->setUser($user);
        $order->setReference(uniqid());

        //On parcourt le panier pour  créer les détails de commande
        foreach ($cart as $id => $quantity) {
            $orderDetails = new OrdersDetails();
            //on va chercher le produit
            $product = $productRepository->find($id);
            $price = $product->getPrice();

            //On créait le détail de commande
            $orderDetails->setProductsId($id);
            $orderDetails->setPrice($price);
            $orderDetails->setQuantity($quantity);
            // Ajout du nom du produit au détail de la commande
            $productName = $product->getNameProduct();
            $orderDetails->setProductName($productName);

            // Calcul de la somme des quantités et des prix
            $totalQuantity += $quantity;
            $totalPrice += ($quantity * $price);

            $order->addOrdersDetail($orderDetails);
        }

        //on persiste et on flush
        $em->persist($order);
        $em->flush();

        $session->remove('panier');

        // $this->addFlash('message', 'Commande créée avec succès');
        // return $this->redirectToRoute('app_home');
        return $this->render('orders/index.html.twig', [
            'orderDetails' => $order->getOrdersDetails(),
            'totalQuantity' => $totalQuantity,
            'totalPrice' => $totalPrice,
        ]);
    }
    #[Route('/liste', name: 'list')]
    public function list(OrdersRepository $ordersRepository): Response
    {
        $orders = $ordersRepository->findAll();

        return $this->render('orders/list.html.twig', [
            'orders' => $orders,
        ]);
    }
}
