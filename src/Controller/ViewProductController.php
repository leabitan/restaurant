<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ViewProductController extends AbstractController
{
    #[Route('/view/product', name: 'app_view_product', methods: ['GET'])]
    public function index(ProductRepository $productRepository, CategoryRepository $categoryRepository): Response
    {
        $products = [];
        if (isset($_GET['categorie_id']) && !empty($_GET['categorie_id'])) {
            $categorie = $categoryRepository->find($_GET['categorie_id']);
            if ($categorie) {
                $products = $categorie->getProduct();
            }
        } else {
            $products = $productRepository->findAll();
        }

        // Récupérer l'image du premier produit comme favicon
        $favicon = null;
        foreach ($products as $product) {
            if ($product->getImage() !== null) {
                $favicon = $product->getImage();
                break;
            }
        }

        // Debugging output
        dump($products);
        dump($favicon);

        return $this->render('view_product/index.html.twig', [
            'controller_name' => 'ViewProductController',
            'products' => $products,
            'favicon' => $favicon,
        ]);
    }
}
