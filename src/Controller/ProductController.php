<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Entity;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_EMPLOYEE')]
#[Route('/product')]
class ProductController extends AbstractController
{
    /**
     * This function displays all products
     *
     * @param ProductRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */



    #[Route('/', name: 'app_product', methods: ['GET'])]
    public function index(ProductRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $product = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('product/index.html.twig', [
            'product' => $product,

        ]);
    }

    #[Route('/nouveau', name: 'product.new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Associe le stock au produit
            $stock = $product->getStock();
            if ($stock) {
                $stock->setProduct($product);
            }
            // Cette ligne récupère les catégories sélectionnées et les associe au produit
            $product = $form->getData();
            foreach ($product->getCategories() as $category) {
                $category->addProduct($product);
            }

            // Gestion du fichier image
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = uniqid() . '.' . $imageFile->guessExtension();

                // Déplace le fichier dans le répertoire public/images
                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );

                // Met à jour la propriété 'image' pour stocker le chemin de l'image
                $product->setImage($newFilename);
            }

            $manager->persist($product);
            $manager->flush();

            $this->addFlash('success', 'Le produit a été créé avec succès');

            return $this->redirectToRoute('app_product', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('product/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/{id}/edit', name: 'product.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Product $product, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Synchroniser les catégories
            $selectedCategories = $form->get('categories')->getData();

            // Supprimer les catégories non sélectionnées
            foreach ($product->getCategories() as $category) {
                if (!$selectedCategories->contains($category)) {
                    $product->removeCategory($category);
                }
            }

            // Ajouter les nouvelles catégories sélectionnées
            foreach ($selectedCategories as $category) {
                if (!$product->getCategories()->contains($category)) {
                    $product->addCategory($category);
                }
            }
            // Associe le stock au produit
            $stock = $product->getStock();
            if ($stock) {
                $stock->setProduct($product);
            }
            // Gestion du fichier image
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = uniqid() . '.' . $imageFile->guessExtension();

                // Déplace le fichier dans le répertoire public/images
                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );

                // Met à jour la propriété 'image' pour stocker le chemin de l'image
                $product->setImage($newFilename);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_product', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('product/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'product.delete', methods: ['GET', 'POST'])]
    public function delete(Request $request, Product $product, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $product->getId(), $request->request->get('_token'))) {
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_product', [], Response::HTTP_SEE_OTHER);
    }
}
