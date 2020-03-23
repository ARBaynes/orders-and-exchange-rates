<?php

namespace App\Service;

use App\Service\Interfaces\ExchangeRateConverterServiceInterface;

class ExchangeRateConverterService implements ExchangeRateConverterServiceInterface
{
    /**
     * @inheritDoc
     */
    public function convert(float $baseAmount, float $quoteAmount): float
    {
        return $baseAmount * $quoteAmount;
    }
}
