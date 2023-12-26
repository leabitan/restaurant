<?php

namespace App\Tests\Unit;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Entity\Product;
use App\Entity\Category;

class ProductTest extends KernelTestCase
{
    public function getEntity(): Product
    {
        return (new Product())
            ->setNameProduct('Test')
            ->setDescription('Test description')
            ->setPrice(1.3)
            ->setActiveProduct(1);
    }

    public function testEntityValid(): void
    {
        self::bootKernel();

        $container = static::getContainer();

        $product = $this->getEntity();

        $errors = $container->get('validator')->validate($product);

        $this->assertCount(0, $errors);
    }

    public function testValidPrixFloat(): void
    {
        self::bootKernel();

        $container = static::getContainer();

        $product = $this->getEntity();
        $product->setPrice(100.23);

        $errors = $container->get('validator')->validate($product);

        $this->assertCount(0, $errors);
    }
    public function testFalsePrixFloat(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $product = $this->getEntity();

        // Utilisation d'une chaîne au lieu d'un nombre flottant
        $this->expectException(\TypeError::class);
        $product->setPrice('100a');

        $errors = $container->get('validator')->validate($product);
        $this->assertCount(1, $errors);
    }

    // public function testFalseTitle(): void
    // {
    //     self::bootKernel();
    //     $container = static::getContainer();

    //     $product = $this->getEntity();
    //     $product->setTitle('');

    //     $errors = $container->get('validator')->validate($product);

    //     // Vous vous attendez à une erreur ici, donc la count devrait être supérieure à zéro
    //     $this->assertGreaterThan(0, count($errors));
    // }

//     public function testProductCategorie()
//     {

//         self::bootKernel();
//         $container = static::getContainer();

//         $product = $this->getEntity();

//         //On va chercher une categorie pour produit
//         $categorie = $container->get('doctrine.orm.entity_manager')->find(Category::class, 1);
//         $product->setCategory($categorie);

//         $errors = $container->get('validator')->validate($product);

//         $this->assertCount(0, $errors);
//     }
// }
