<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class Currency
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $code;
    /**
     * @var ArrayCollection<ConversionRate>
     */
    private $conversionRates;

    /**
     * Currency constructor.
     * @param string $name
     * @param string $code
     * @param ArrayCollection<ConversionRate> $conversionRates
     */
    private function __construct(
      string $name,
      string $code,
      ArrayCollection $conversionRates
    ) {
        $this->name = $name;
        $this->code = $code;
        $this->conversionRates = $conversionRates;
    }

    /**
     * @param string $name
     * @param string $code
     * @param ArrayCollection<ConversionRate> $conversionRates
     * @return Currency
     */
    public static function build(
        string $name,
        string $code,
        ArrayCollection $conversionRates
    ): Currency {
        return new Currency($name, $code, $conversionRates);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return ArrayCollection<ConversionRate>
     */
    public function getConversionRates(): ArrayCollection
    {
        return $this->conversionRates;
    }
}
