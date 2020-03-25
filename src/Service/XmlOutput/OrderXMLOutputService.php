<?php

namespace App\Service\XmlOutput;

use Doctrine\Common\Collections\ArrayCollection;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class OrderXMLOutputService
{
    /**
     * @var Environment
     */
    private $twigEnvironment;

    /**
     * OrderXMLOutputService constructor.
     * @param Environment $twigEnvironment
     */
    public function __construct()
    {
        $this->twigEnvironment = $twigEnvironment;
    }

    /**
     * @param ArrayCollection $orders
     * @return bool
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function output(ArrayCollection $orders): bool
    {
        $this->twigEnvironment->render(
            'order_template.xml.twig'
        );
        var_dump($orders);
        return true;
    }
}
