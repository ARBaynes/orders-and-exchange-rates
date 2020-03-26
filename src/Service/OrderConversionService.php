<?php

namespace App\Service;

use App\Entity\ConversionRate;
use App\Entity\Order;
use App\Entity\Product;

class OrderConversionService
{
    /**
     * @param Order $order
     * @param ConversionRate $conversionRate
     * @return Order
     */
    public static function convert(Order $order, ConversionRate $conversionRate): Order
    {
        $order->setCurrencyCode($conversionRate->getQuoteCurrencyCode());
        $order->getProducts()->map(
            static function(Product $product) use ($conversionRate) {
                $product->setPrice(ExchangeRateConverterService::convert($product->getPrice(), $conversionRate->getQuoteCurrencyAmount()));
            }
        );
        $order->setTotal($order->calculateTotalFromProducts());
        return $order;
    }

}
