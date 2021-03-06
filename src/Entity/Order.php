<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class Order
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $currencyCode;
    /**
     * @var \DateTime
     */
    private $date;
    /**
     * @var ArrayCollection<Product>
     */
    private $products;
    /**
     * @var float
     */
    private $total;

    /**
     * Order constructor.
     * @param int $id
     * @param string $currencyCode
     * @param \DateTime $date
     * @param ArrayCollection<Product> $products
     * @param float $total
     */
    private function __construct(
        int $id,
        string $currencyCode,
        \DateTime $date,
        ArrayCollection $products,
        float $total
    ) {
        $this->id = $id;
        $this->currencyCode = $currencyCode;
        $this->date = $date;
        $this->products = $products;
        $this->total = $total;
    }

    /**
     * @param int $id
     * @param string $currencyCode
     * @param \DateTime $date
     * @param ArrayCollection $products
     * @param float $total
     * @return Order
     */
    public static function build(
        int $id,
        string $currencyCode,
        \DateTime $date,
        ArrayCollection $products,
        float $total
    ): Order {
        return new Order($id, $currencyCode, $date, $products, $total);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getCurrencyCode(): string
    {
        return $this->currencyCode;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    /**
     * @return ArrayCollection<Product>
     */
    public function getProducts(): ArrayCollection
    {
        return $this->products;
    }

    /**
     * @return float
     */
    public function getTotal(): float
    {
        return $this->total;
    }

    /**
     * @param string $currencyCode
     */
    public function setCurrencyCode(string $currencyCode): void
    {
        $this->currencyCode = $currencyCode;
    }

    /**
     * @param ArrayCollection<Product> $products
     */
    public function setProducts(ArrayCollection $products): void
    {
        $this->products = $products;
    }

    /**
     * @param float|null $total
     */
    public function setTotal(?float $total): void
    {
        $this->total = $total ?? $this->calculateTotalFromProducts();
    }

    /**
     * @return float
     */
    public function calculateTotalFromProducts(): float
    {
        $total = 0.00;
        foreach ($this->getProducts()->toArray() as $product) {
            $total += $product->getPrice();
        }
        return round($total, 2);
    }
}
