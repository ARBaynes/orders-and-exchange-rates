<?php

namespace App\Entity;

use DateTime;

class ConversionRate
{
    /**
     * @var DateTime
     */
    private $date;
    /**
     * @var string
     */
    private $quoteCurrencyCode;
    /**
     * @var float
     */
    private $quoteCurrencyAmount;

    /**
     * ConversionRate constructor.
     * @param DateTime $date
     * @param string $quoteCurrencyCode
     * @param float $quoteCurrencyAmount
     */
    private function __construct(
        DateTime $date,
        string $quoteCurrencyCode,
        float $quoteCurrencyAmount
    ) {
        $this->date = $date;
        $this->quoteCurrencyCode = $quoteCurrencyCode;
        $this->quoteCurrencyAmount = $quoteCurrencyAmount;
    }

    /**
     * @param DateTime $date
     * @param string $quoteCurrencyCode
     * @param float $quoteCurrencyAmount
     * @return ConversionRate
     */
    public static function build(
        DateTime $date,
        string $quoteCurrencyCode,
        float $quoteCurrencyAmount
    ): ConversionRate {
        return new ConversionRate(
            $date,
            $quoteCurrencyCode,
            $quoteCurrencyAmount
        );
    }

    /**
     * @return DateTime
     */
    public function getDate(): DateTime
    {
        return $this->date;
    }

    /**
     * @return string
     */
    public function getQuoteCurrencyCode(): string
    {
        return $this->quoteCurrencyCode;
    }

    /**
     * @return float
     */
    public function getQuoteCurrencyAmount(): float
    {
        return $this->quoteCurrencyAmount;
    }
}
