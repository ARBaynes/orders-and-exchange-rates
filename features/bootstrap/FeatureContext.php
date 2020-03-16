<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @Given there is an order which totals up to :orderAmount :orderCurrency
     */
    public function thereIsAnOrderWhichTotalsUpTo($orderAmount, $orderCurrency)
    {
        throw new PendingException();
    }

    /**
     * @When I choose to convert the currency to :conversionCurrency
     */
    public function iChooseToConvertTheCurrencyToAnotherCurrency($conversionCurrency)
    {
        throw new PendingException();
    }


    /**
     * @Given the exchange rate is :conversionCurrency :conversionCurrencyType to :baseCurrency :baseCurrencyType
     */
    public function theCurrencyRateIsConversionCurrencyToBaseCurrency(
        $conversionCurrency,
        $conversionCurrencyType,
        $baseCurrency,
        $baseCurrencyType
    ) {
        throw new \Behat\Behat\Tester\Exception\PendingException();
    }

    /**
     * @Then I should see the order totals up to :arg1 GBP
     */
    public function iShouldSeeTheOrderTotalsUpToGbp($arg1)
    {
        throw new PendingException();
    }
}
