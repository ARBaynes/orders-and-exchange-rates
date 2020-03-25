<?php

namespace App\Service\Parser;

use App\Entity\ConversionRate;
use App\Entity\Currency;
use App\Service\DateConversionService;
use App\Service\Interfaces\ParserInterface;
use Doctrine\Common\Collections\ArrayCollection;

class ExchangeRateXMLParser implements ParserInterface
{
    /**
     * @param string $xmlFilePath
     * @return ArrayCollection<Currency>
     */
    public function parse(string $xmlFilePath): ArrayCollection
    {
        try {
            $xmlFile = file_get_contents($xmlFilePath);
            $xml = simplexml_load_string($xmlFile);
        } catch (\Exception $exception) {
            throw new \RuntimeException('Exchange rate file could not be loaded: ' .$exception->getMessage());
        }

        # Unfortunately I don't have the time to configure JMS,
        # however it'd be a nice future improvement :)

        $exchangeRates = [];

        foreach ($xml->children() as $currencyChildElement) {
            $baseCurrencyCode = $currencyChildElement->children()->code;
            $conversionRates = $this->traverseRatesNodes($baseCurrencyCode, $currencyChildElement);

            $exchangeRates[] = Currency::build(
                $currencyChildElement->children()->name,
                $currencyChildElement->children()->code,
                $conversionRates
            );
        }

        return new ArrayCollection($exchangeRates);
    }

    /**
     * @param string $baseCurrencyCode
     * @param \SimpleXMLElement $currencyXMLElement
     * @return ArrayCollection
     */
    private function traverseRatesNodes(
        string $baseCurrencyCode,
        \SimpleXMLElement $currencyXMLElement
    ): ArrayCollection {
        $conversionRates = [];
        foreach ($currencyXMLElement->children()->rateHistory->children() as $rateCurrency) {
            foreach ($rateCurrency->children() as $rate) {
                if ($rate->attributes()->code->__toString() !== $baseCurrencyCode) {
                    $conversionRates[] = ConversionRate::build(
                        DateConversionService::convert($rateCurrency->attributes()->date),
                        $rate->attributes()->code,
                        (float) $rate->attributes()->value
                    );
                }
            }
        }
        return new ArrayCollection($conversionRates);
    }
}
