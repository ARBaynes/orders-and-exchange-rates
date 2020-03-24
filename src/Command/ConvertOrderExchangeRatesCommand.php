<?php

namespace App\Command;

use App\Entity\Order;
use App\Service\ExchangeRateConverterService;
use App\Service\Parser\ExchangeRateXMLParser;
use App\Service\Parser\OrderXMLParser;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConvertOrderExchangeRatesCommand extends Command
{
    protected static $defaultName = 'order:convert-exchange-rate';

    /**
     * @var OrderXMLParser
     */
    private $orderXMLParser;
    /**
     * @var ExchangeRateConverterService
     */
    private $exchangeRateConverter;
    /**
     * @var ExchangeRateXMLParser
     */
    private $exchangeRateXMLParser;

    /**
     * ConvertOrderExchangeRatesCommand constructor.
     * @param OrderXMLParser $orderXMLParser
     * @param ExchangeRateXMLParser $exchangeRateXMLParser
     * @param ExchangeRateConverterService $exchangeRateConverter
     */
    public function __construct(
        OrderXMLParser $orderXMLParser,
        ExchangeRateXMLParser $exchangeRateXMLParser,
        ExchangeRateConverterService $exchangeRateConverter
    ) {
        $this->orderXMLParser = $orderXMLParser;
        $this->exchangeRateXMLParser = $exchangeRateXMLParser;
        $this->exchangeRateConverter = $exchangeRateConverter;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('orderPath', InputArgument::REQUIRED, 'The path to the XML order file.')
            ->addArgument('exchangeRatePath', InputArgument::REQUIRED, 'The path to the exchange rates XML file.')
            ->addArgument('currencyCode', InputArgument::REQUIRED, 'The currency code you wish to convert the order to.')
            ->setDescription('Converts the currency of an order into another.');
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $orderPath = $input->getArgument('orderPath');
        $exchangeRatePath = $input->getArgument('exchangeRatePath');
        $currencyCode = $input->getArgument('currencyCode');

        $orders = $this->orderXMLParser->parse($orderPath);
        $exchangeRates = $this->exchangeRateXMLParser->parse($exchangeRatePath);

        $output->writeln("<info>Transforming into currency {$currencyCode}</info>");
        return 0;
    }
}
