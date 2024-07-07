<?php

namespace App\Entity;

use App\Repository\StockRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StockRepository::class)]
class Stock
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $quantitySold = null;

    #[ORM\Column(nullable: true)]
    private ?int $quantityPrepared = null;

    #[ORM\Column(nullable: true)]
    private ?int $quantityReal = null;

    #[ORM\OneToOne(mappedBy: 'stock', cascade: ['persist', 'remove'])]
    private ?Product $product = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantitySold(): ?int
    {
        return $this->quantitySold;
    }

    public function setQuantitySold(?int $quantitySold): static
    {
        $this->quantitySold = $quantitySold;
        $this->updateQuantityReal();
        return $this;
    }

    public function getQuantityPrepared(): ?int
    {
        return $this->quantityPrepared;
    }

    public function setQuantityPrepared(?int $quantityPrepared): static
    {
        $this->quantityPrepared = $quantityPrepared;
        $this->updateQuantityReal();
        return $this;
    }

    public function getQuantityReal(): ?int
    {
        return $this->quantityReal;
    }

    private function updateQuantityReal(): void
    {
        if ($this->quantityPrepared !== null && $this->quantitySold !== null) {
            $this->quantityReal = $this->quantityPrepared - $this->quantitySold;
        }
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): static
    {
        // unset the owning side of the relation if necessary
        if ($product === null && $this->product !== null) {
            $this->product->setStock(null);
        }

        // set the owning side of the relation if necessary
        if ($product !== null && $product->getStock() !== $this) {
            $product->setStock($this);
        }

        $this->product = $product;

        return $this;
    }
}
