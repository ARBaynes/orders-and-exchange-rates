<?php

namespace App\Entity;

class Product
{
    /**
     * @var string
     */
    private $title;
    /**
     * @var float
     */
    private $price;

    /**
     * Product constructor.
     * @param string $title
     * @param float $price
     */
    private function __construct(
        string $title,
        float $price
    ) {
        $this->title = $title;
        $this->price = $price;
    }

    public static function build(
        string $title,
        float $price
    ): Product {
        return new Product($title, $price);
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }
}
