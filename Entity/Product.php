<?php

namespace Belous\ProductsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Belous\ProductsBundle\Repository\ProductRepository")
 */
class Product
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
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="Belous\ProductsBundle\Entity\ProductType", inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

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
     * @return Product
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get price
     *
     * @return float|null
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * Set price
     *
     * @param float $price
     * @return Product
     */
    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get type
     *
     * @return ProductType|null
     */
    public function getType(): ?ProductType
    {
        return $this->type;
    }

    /**
     * Set type
     *
     * @param ProductType|null $type
     * @return Product
     */
    public function setType(?ProductType $type): self
    {
        $this->type = $type;

        return $this;
    }
}
