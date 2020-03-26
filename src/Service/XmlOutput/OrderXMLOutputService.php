<?php

namespace App\Service\XmlOutput;

use App\Exception\XMLOutputException;
use Doctrine\Common\Collections\ArrayCollection;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class OrderXMLOutputService
{
    /**
     * @var string
     */
    private $outputFilePath;
    /**
     * @var Environment
     */
    private $twigEnvironment;

    /**
     * OrderXMLOutputService constructor.
     * @param string $outputFilePath
     * @param Environment $twigEnvironment
     */
    public function __construct(
        string $outputFilePath,
        Environment $twigEnvironment
    ) {
        $this->outputFilePath = $outputFilePath;
        $this->twigEnvironment = $twigEnvironment;
    }

    /**
     * @param ArrayCollection $orders
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws XMLOutputException
     */
    public function output(ArrayCollection $orders): string
    {
        $output = $this->twigEnvironment->render('order_template.xml.twig', ['orders' => $orders]);

        try {
            $outputFile = fopen($this->outputFilePath, 'wb');
        } catch (\Exception $exception) {
            throw new XMLOutputException("File at {$this->outputFilePath} could not be opened.");
        }

        try {
            fwrite($outputFile, $output);
        } catch (\Exception $exception) {
            throw new XMLOutputException("File at {$this->outputFilePath} could not be written to with {$output}");
        }

        fclose($outputFile);
        return $this->outputFilePath;
    }
}
