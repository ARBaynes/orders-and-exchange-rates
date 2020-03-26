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
        return round(
            (
                $quoteAmount < 1 && $quoteAmount > 0 ?
                    $baseAmount / $quoteAmount :$baseAmount * $quoteAmount
            ),
            2
        );
    }
}
