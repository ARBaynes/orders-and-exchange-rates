<?php

use App\Entity\ConversionRate;
use App\Entity\Order;
use App\Entity\Product;
use App\Exception\CurrencyConversionException;
use Behat\Behat\Context\Context;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Defines application features from the specific context.
 */
class ExchangeContext implements Context
{
    /** @var ConversionRate */
    private $conversionRate;
    /** @var Order */
    private $order;
    /** @var Order */
    private $convertedOrder;

    public function __construct()
    {
    }

    /**
     * @Given there is an order with id :id for :productOne at :productOnePrice :productOneCurrency and :productTwo at :productTwoPrice :productTwoCurrency that totals up to :orderTotal :orderCurrency
     */
    public function thereIsAnOrderWhichTotalsUpTo(
        $id,
        $productOne,
        $productOnePrice,
        $productOneCurrency,
        $productTwo,
        $productTwoPrice,
        $productTwoCurrency,
        $orderTotal,
        $orderCurrency
    ) {
        $products = new ArrayCollection([
            Product::build($productOne, $productOnePrice),
            Product::build($productTwo, $productTwoPrice)
        ]);
        $this->order = Order::build($id, $orderCurrency, new DateTime(), $products, $orderTotal);
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
        $this->conversionRate = ConversionRate::build(new DateTime(), $quoteCurrencyType, $quoteCurrency);
    }

    /**
     * @When I convert the currency to :quoteCurrencyType
     */
    public function iConvertTheCurrencyToAnotherCurrency($quoteCurrencyType) {
        $this->convertedOrder = \App\Service\OrderConversionService::convert($this->order, $this->conversionRate);
    }

    /**
     * @Then I should see the order totals up to :finalConvertedAmount :convertedCurrency
     * @throws CurrencyConversionException
     */
    public function iShouldSeeTheOrderTotalsUpToCurrency($finalConvertedAmount, $convertedCurrency)
    {
        if ((float) $finalConvertedAmount !== $this->convertedOrder->getTotal()) {
            throw new CurrencyConversionException(
                "Expected {$finalConvertedAmount} did not match {$this->convertedOrder->getTotal()}"
            );
        }
    }
}
