<?php

namespace App\Command;

use App\Entity\ConversionRate;
use App\Entity\Currency;
use App\Entity\Order;
use App\Entity\Product;
use App\Service\ExchangeRateConverterService;
use App\Service\OrderConversionService;
use App\Service\Parser\ExchangeRateXMLParser;
use App\Service\Parser\OrderXMLParser;
use App\Service\XmlOutput\OrderXMLOutputService;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConvertOrderExchangeRatesCommand extends Command
{
    protected static $defaultName = 'order:convert-exchange-rate';

    /** @var string */
    private $orderPath;
    /** @var string */
    private $exchangeRatePath;
    /** @var OrderXMLParser */
    private $orderXMLParser;
    /** @var ExchangeRateXMLParser */
    private $exchangeRateXMLParser;
    /** @var OrderXMLOutputService */
    private $orderXMLOutputService;

    /**
     * ConvertOrderExchangeRatesCommand constructor.
     * @param string $orderPath
     * @param string $exchangeRatePath
     * @param OrderXMLParser $orderXMLParser
     * @param ExchangeRateXMLParser $exchangeRateXMLParser
     * @param OrderXMLOutputService $orderXMLOutputService
     */
    public function __construct(
        string $orderPath,
        string $exchangeRatePath,
        OrderXMLParser $orderXMLParser,
        ExchangeRateXMLParser $exchangeRateXMLParser,
        OrderXMLOutputService $orderXMLOutputService
    ) {
        $this->orderPath = $orderPath;
        $this->exchangeRatePath = $exchangeRatePath;
        $this->orderXMLParser = $orderXMLParser;
        $this->exchangeRateXMLParser = $exchangeRateXMLParser;
        $this->orderXMLOutputService = $orderXMLOutputService;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Converts the currency of an order into the most recent non-base exchange rate found.');
    }


    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $output->writeln('<info>Loading XML files</info>');

        $orders = $this->orderXMLParser->parse($this->orderPath);
        $exchangeRates = $this->exchangeRateXMLParser->parse($this->exchangeRatePath);

        $output->writeln('<info>Transforming currencies</info>');

        # Future improvement: Move the below logic into separate services so that it is cleaner and more readable.

        $convertedOrders = [];
        /** @var Order $order */
        foreach ($orders->toArray() as $order) {
            /** @var Currency $baseCurrency */
            $baseCurrency = $exchangeRates->filter(static function (Currency $currency) use ($order) {
                return $currency->getCode() === $order->getCurrencyCode();
            })->first();

            $baseCurrency->getConversionRates()->getIterator()->uasort(static function (ConversionRate $a, ConversionRate $b) {
                return ($a->getDate() < $b->getDate()) ? -1 : 1;
            });

            /** @var ConversionRate $quoteRate */
            $quoteRate = $baseCurrency->getConversionRates()->last();

            $output->writeln(
                "<info>Converting order {$order->getId()} -> {$order->getTotal()} {$order->getCurrencyCode()} to {$quoteRate->getQuoteCurrencyCode()} with conversion rate {$quoteRate->getQuoteCurrencyAmount()}</info>");

            $convertedOrders[] = OrderConversionService::convert($order, $quoteRate);
        }

        $outputSuccess = $this->orderXMLOutputService->output(new ArrayCollection($convertedOrders));

        $output->writeln('<info>Command finished: '.($outputSuccess ? "Converted orders have been placed in '{$outputSuccess}'" : 'Failure').'</info>');

        return 0;
    }
}
