<?php

namespace App\Command;

use App\Service\ExchangeRateConverterService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConvertOrderExchangeRatesCommand extends Command
{
    protected static $defaultName = 'order:convert-exchange-rate';

    /**
     * @var ExchangeRateConverterService
     */
    private $exchangeRateConverter;

    public function __construct(ExchangeRateConverterService $exchangeRateConverter)
    {
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


        $output->writeln("<info>Transforming into currency {$currencyCode}</info>");
        return 0;
    }
}
