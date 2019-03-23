<?php

namespace Belous\ProductsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Belous\ProductsBundle\Repository\ProductTypeRepository")
 */
class ProductType
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Belous\ProductsBundle\Entity\Product", mappedBy="type")
     */
    private $products;

    /**
     * ProductType constructor.
     */
    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get name
     *
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return ProductType
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Add a product
     * @param Product $product
     * @return ProductType
     */
    public function addProduct(Product $product):self
    {
        if (!$this->products->contains($product)) {
            $product->setType($this);
            $this->products->add($product);
        }

        return $this;
    }

    /**
     * Remove product
     *
     * @param Product $product
     * @return ProductType
     */
    public function removeProduct(Product $product): self
    {
        $this->products->removeElement($product);
        return $this;
    }

    /**
     * @return Product[]|ArrayCollection
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     *  Returns sums of product prices
     *
     * @return float
     */
    public function  getSums0fProductPrices():float
    {
        $sum = 0;
        foreach ($this->getProducts() as $product) {
            $sum += $product->getPrice();
        }

        return $sum;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return (string)$this->getName();
    }
}
