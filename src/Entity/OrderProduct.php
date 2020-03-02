<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Entity()
 * @ORM\Table(name="app_order_product")
 */
class OrderProduct
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
     */
    private $id;

    /**
     * @var Order
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Order")
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $order;

    /**
     * @var Product
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Product")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", onDelete="CASCADE")
     *
     * @JMS\SerializedName("product")
     * @JMS\Type("App\Entity\Product")
     * @JMS\Groups({"orderCreate"})
     */
    private $product;

    /**
     * @var float
     *
     * @ORM\Column(name="quantity", type="float", precision=9, scale=2, nullable=false)
     *
     * @JMS\SerializedName("quantity")
     * @JMS\Type("float")
     * @JMS\Groups({"orderCreate"})
     */
    private $quantity;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float", precision=9, scale=2, nullable=false)
     *
     * @JMS\SerializedName("price")
     * @JMS\Type("float")
     * @JMS\Groups({"orderCreate"})
     */
    private $price;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Order
     */
    public function getOrder(): Order
    {
        return $this->order;
    }

    /**
     * @param Order $order
     *
     * @return OrderProduct
     */
    public function setOrder(Order $order): OrderProduct
    {
        $this->order = $order;

        return $this;
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @param Product $product
     *
     * @return OrderProduct
     */
    public function setProduct(Product $product): OrderProduct
    {
        $this->product = $product;

        return $this;
    }

    /**
     * @return float
     */
    public function getQuantity(): float
    {
        return $this->quantity;
    }

    /**
     * @param float $quantity
     *
     * @return OrderProduct
     */
    public function setQuantity(float $quantity): OrderProduct
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     *
     * @return OrderProduct
     */
    public function setPrice(float $price): OrderProduct
    {
        $this->price = $price;

        return $this;
    }
}
