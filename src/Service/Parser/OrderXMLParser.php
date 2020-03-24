<?php

namespace App\Service\Parser;

use App\Entity\Order;
use App\Entity\Product;
use App\Service\DateConversionService;
use App\Service\Interfaces\ParserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;

class OrderXMLParser implements ParserInterface
{
    /**
     * @param string $xmlFilePath
     * @return ArrayCollection
     */
    public function parse(string $xmlFilePath): ArrayCollection
    {
        try {
            $xmlFile = file_get_contents($xmlFilePath);
            $xml = simplexml_load_string($xmlFile);
        } catch (\Exception $exception) {
            throw new \RuntimeException('Orders file could not be loaded: ' .$exception->getMessage());
        }

        # Unfortunately I don't have the time to configure JMS,
        # however it'd be a nice future improvement :)

        $orders = [];

        foreach ($xml->children() as $orderChildElement) {
            $products = [];

            foreach ($orderChildElement->children()->products->children() as $product) {
                $products[] = Product::build(
                    $product->attributes()->title,
                    (float) $product->attributes()->price
                );
            }

            $orders[] = Order::build(
                (int) $orderChildElement->children()->id,
                $orderChildElement->children()->currency,
                DateConversionService::convert($orderChildElement->children()->date),
                new ArrayCollection($products),
                (float) $orderChildElement->children()->total
            );
        }

        return new ArrayCollection($orders);
    }
}
