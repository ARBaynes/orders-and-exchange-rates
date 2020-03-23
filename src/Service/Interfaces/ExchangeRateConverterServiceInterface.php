<?php

namespace App\Service\Interfaces;

interface ExchangeRateConverterServiceInterface
{
    /**
     * @param float $baseAmount
     * @param float $quoteAmount
     * @return float
     */
    public function convert(float $baseAmount, float $quoteAmount): float;
}
