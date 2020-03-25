<?php

namespace App\Service;

use App\Service\Interfaces\ExchangeRateConverterServiceInterface;

class ExchangeRateConverterService implements ExchangeRateConverterServiceInterface
{
    /**
     * @inheritDoc
     */
    public static function convert(float $baseAmount, float $quoteAmount): float
    {
        return round($baseAmount * $quoteAmount, 2);
    }
}
