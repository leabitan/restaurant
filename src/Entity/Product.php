<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[UniqueEntity('name_product')]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name_product = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $image = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column]
    private ?bool $active_product = null;

    #[ORM\ManyToMany(targetEntity: Category::class, mappedBy: 'product')]
    private Collection $categories;

    // #[ORM\ManyToMany(targetEntity: Cart::class, inversedBy: 'products')]
    // private Collection $cart;

    #[ORM\OneToOne(inversedBy: 'product', cascade: ['persist', 'remove'])]
    private ?Stock $stock = null;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        // $this->cart = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameProduct(): ?string
    {
        return $this->name_product;
    }

    public function setNameProduct(string $name_product): static
    {
        $this->name_product = $name_product;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function __toString()
    {
        return $this->id;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }


    public function isActiveProduct(): ?bool
    {
        return $this->active_product;
    }

    public function setActiveProduct(bool $active_product): static
    {
        $this->active_product = $active_product;

        return $this;
    }



    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
            $category->addProduct($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): static
    {
        if ($this->categories->removeElement($category)) {
            $category->removeProduct($this);
        }

        return $this;
    }

    // /**
    //  * @return Collection<int, Cart>
    //  */
    // public function getCart(): Collection
    // {
    //     return $this->cart;
    // }

    // public function addCart(Cart $cart): static
    // {
    //     if (!$this->cart->contains($cart)) {
    //         $this->cart->add($cart);
    //     }

    //     return $this;
    // }

    // public function removeCart(Cart $cart): static
    // {
    //     $this->cart->removeElement($cart);

    //     return $this;
    // }

    public function getStock(): ?Stock
    {
        return $this->stock;
    }

    public function setStock(?Stock $stock): static
    {
        $this->stock = $stock;

        return $this;
    }
}
