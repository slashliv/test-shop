<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Entity()
 * @ORM\Table(name="app_order_status")
 */
class OrderStatus
{
    const CODE_NEW = 'new';
    const CODE_PAID = 'paid';

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
     * @var string
     *
     * @ORM\Column(name="code", type="string", nullable=false, unique=true)
     *
     * @JMS\SerializedName("code")
     * @JMS\Type("string")
     * @JMS\Groups({
     *     "orderCreate",
     *     "pay"
     * })
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", nullable=false)
     *
     * @JMS\SerializedName("name")
     * @JMS\Type("string")
     * @JMS\Groups({
     *     "orderCreate",
     *     "pay"
     * })
     */
    private $name;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     *
     * @return OrderStatus
     */
    public function setCode(string $code): OrderStatus
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return OrderStatus
     */
    public function setName(string $name): OrderStatus
    {
        $this->name = $name;

        return $this;
    }
}
