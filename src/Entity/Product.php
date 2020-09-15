<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product implements JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $featured;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $image_file_name;

    /**
     * @ORM\Column(type="string", length=5000, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $in_stock;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFeatured(): ?bool
    {
        return $this->featured;
    }

    public function setFeatured(?bool $featured): self
    {
        $this->featured = $featured;

        return $this;
    }

    /**
     * Images are stored as string filenames in database. The image actual is retrieved at a template level.
     */

    public function getImageFileName(): ?string
    {
        return $this->image_file_name;
    }

    public function setImageFileName(?string $image_file_name): self
    {
        $this->image_file_name = $image_file_name;

        return $this;
    }

    public function jsonSerialize() {
        return [
            'id' => $this->getId(),
            'price' => $this->getPrice(),
            'name' => $this->getName(),
            'featured' => $this->getFeatured(),
            'image_file_name' => $this->getImageFileName(),
            'in_stock' => $this->getInStock(),
            'description' => $this->getDescription()
        ];
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getInStock(): ?int
    {
        return $this->in_stock;
    }

    public function setInStock(?int $in_stock): self
    {
        $this->in_stock = $in_stock;

        return $this;
    }
}
