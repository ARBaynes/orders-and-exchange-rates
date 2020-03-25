<?php

namespace App\Service\Interfaces;

interface ExchangeRateConverterServiceInterface
{
    /**
     * @param float $baseAmount
     * @param float $quoteAmount
     * @return float
     */
    public static function convert(float $baseAmount, float $quoteAmount): float;
}
