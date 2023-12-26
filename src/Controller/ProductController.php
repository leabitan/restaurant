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

// #[IsGranted('ROLE_EMPLOYEE')]
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

    #[Route('/nouveau', 'product.new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $manager
    ): Response {
        $product = new product();
        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();
            $manager->persist($product);
            $manager->flush();

            // message flash

            $this->addFlash(
                'success',
                'Le plat a été créé avec succès'
            );
            return $this->redirectToRoute('app_product', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('product/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/{id}/edit', name: 'product.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Product $product, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_product', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('product/edit.html.twig', [
            'product' => $product,
            'form' => $form,
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
