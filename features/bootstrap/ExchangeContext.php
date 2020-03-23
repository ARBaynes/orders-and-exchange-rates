<?php

use App\Exception\CurrencyConversionException;
use App\Service\ExchangeRateConverterService;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;

/**
 * Defines application features from the specific context.
 */
class ExchangeContext implements Context
{
    /** @var ExchangeRateConverterService */
    private $exchangeRateConverter;
    /** @var string */
    private $exchangeRateFilepath;
    /** @var string */
    private $testOrdersFilepath;
    
    /** @var float */
    private $baseCurrency;
    /** @var float */
    private $quoteCurrency;
    /** @var float */
    private $convertedCurrency;

    /**
     * FeatureContext constructor.
     * @param string $exchangeRateFilepath
     * @param string $testOrdersFilepath
     */
    public function __construct(string $exchangeRateFilepath, string $testOrdersFilepath) {
        $this->exchangeRateFilepath = $exchangeRateFilepath;
        $this->testOrdersFilepath = $testOrdersFilepath;
        $this->exchangeRateConverter = new ExchangeRateConverterService();
    }

    /**
     * @Given there is an order which totals up to :orderAmount :orderCurrency
     */
    public function thereIsAnOrderWhichTotalsUpTo($orderAmount, $orderCurrency)
    {
        throw new PendingException();
    }

    /**
     * @param $quoteCurrency
     * @param $quoteCurrencyType
     * @param $baseCurrency
     * @param $baseCurrencyType
     *
     * @Given the exchange rate is :quoteCurrency :quoteCurrencyType to :baseCurrency :baseCurrencyType
     */
    public function theExchangeRateIsQuoteCurrencyToBaseCurrency(
        $quoteCurrency,
        $quoteCurrencyType,
        $baseCurrency,
        $baseCurrencyType
    ) {
        $this->baseCurrency = $baseCurrency;
        $this->quoteCurrency = $quoteCurrency;
    }

    /**
     * @When I convert the currency to :quoteCurrencyType
     */
    public function iConvertTheCurrencyToAnotherCurrency($quoteCurrencyType) {
        $this->convertedCurrency = $this->exchangeRateConverter->convert($this->baseCurrency, $this->quoteCurrency);
    }


    /**
     * @Then I should see the order totals up to :finalConvertedAmount GBP
     * @throws CurrencyConversionException
     */
    public function iShouldSeeTheOrderTotalsUpToGbp($finalConvertedAmount)
    {
        if ($finalConvertedAmount !== $this->convertedCurrency) {
            throw new CurrencyConversionException(
                "Expected {$finalConvertedAmount} did not match {$this->convertedCurrency}"
            );
        }
    }
}
