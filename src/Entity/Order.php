<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 * @ORM\Table(name="app_order")
 */
class Order
{
    /**
     * @var int|null
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(name="id", type="integer")
     *
     * @JMS\SerializedName("id")
     * @JMS\Type("integer")
     * @JMS\Groups({
     *     "orderCreate",
     *     "pay"
     * })
     */
    private $id;

    /**
     * @var OrderStatus
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\OrderStatus")
     * @ORM\JoinColumn(name="status_id", referencedColumnName="id")
     *
     * @JMS\SerializedName("status")
     * @JMS\Type("App\Entity\OrderStatus")
     * @JMS\Groups({
     *     "orderCreate",
     *     "pay"
     * })
     */
    private $status;

    /**
     * @var OrderProduct[]
     *
     * @ORM\OneToMany(targetEntity="App\Entity\OrderProduct", mappedBy="order", cascade={"persist"})
     *
     * @JMS\SerializedName("products")
     * @JMS\Type("ArrayCollection<App\Entity\OrderProduct>")
     * @JMS\Groups({"orderCreate"})
     */
    private $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    /**
     * @return float
     */
    public function getTotalSum(): float
    {
        $sum = 0;
        foreach ($this->products as $product) {
            $sum += $product->getPrice() * $product->getQuantity();
        }

        return $sum;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return OrderStatus
     */
    public function getStatus(): OrderStatus
    {
        return $this->status;
    }

    /**
     * @param OrderStatus $status
     *
     * @return Order
     */
    public function setStatus(OrderStatus $status): Order
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection|OrderProduct[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    /**
     * @param OrderProduct $product
     *
     * @return $this
     */
    public function addProduct(OrderProduct $product)
    {
        $this->products->add($product);
        $product->setOrder($this);

        return $this;
    }

    /**
     * @param OrderProduct[] $products
     *
     * @return Order
     */
    public function setProducts(array $products): Order
    {
        $this->products = $products;

        return $this;
    }
}