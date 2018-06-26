<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StockRepository")
 * @UniqueEntity(fields={"productCode"}, message="This Product code is already in use")
 */
class Stock
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(
     *     message="Field Product code must be filled"
     * )
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Product code cannot be longer than {{ limit }} characters"
     * )
     * @ORM\Column(type="string", length=255, nullable=false, unique=true)
     */
    private $productCode;

    /**
     * @Assert\NotBlank(
     *     message="Field Product name must be filled"
     * )
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Product name cannot be longer than {{ limit }} characters"
     * )
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $productName;

    /**
     * @Assert\NotBlank(
     *     message="Field Product description must be filled"
     * )
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Product description cannot be longer than {{ limit }} characters"
     * )
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $productDescription;

    /**
     * @Assert\NotBlank(
     *     message="Field Stock must be filled"
     * )
     * @ORM\Column(type="string", nullable=false)
     */
    private $stock;

    /**
     * @Assert\NotBlank(
     *     message="Field Cost must be filled"
     * )
     * @ORM\Column(type="string", nullable=false)
     */
    private $costInGBP;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $discontinued;

    public function getId()
    {
        return $this->id;
    }

    public function getProductCode(): ?string
    {
        return $this->productCode;
    }

    public function setProductCode(string $productCode): self
    {
        $this->productCode = $productCode;

        return $this;
    }

    public function getProductName(): ?string
    {
        return $this->productName;
    }

    public function setProductName(string $productName): self
    {
        $this->productName = $productName;

        return $this;
    }

    public function getProductDescription(): ?string
    {
        return $this->productDescription;
    }

    public function setProductDescription(string $productDescription): self
    {
        $this->productDescription = $productDescription;

        return $this;
    }

    public function getStock(): ?string
    {
        return $this->stock;
    }

    public function setStock(string $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getCostInGBP(): ?string
    {
        return $this->costInGBP;
    }

    public function setCostInGBP(string $costInGBP): self
    {
        $this->costInGBP = $costInGBP;

        return $this;
    }

    public function getDiscontinued(): ?string
    {
        return $this->discontinued;
    }

    public function setDiscontinued(?string $discontinued): self
    {
        $this->discontinued = $discontinued;

        return $this;
    }
}
