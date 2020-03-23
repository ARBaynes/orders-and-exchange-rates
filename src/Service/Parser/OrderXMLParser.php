<?php

namespace App\Service\Parser;

use App\Service\Interfaces\ParserInterface;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;

class OrderXMLParser implements ParserInterface
{
    /**
     * @param string $xmlFilePath
     */
    public function parse(string $xmlFilePath)
    {
        // TODO: Implement parse() method.
        try {
            file_get_contents($xmlFilePath);
        } catch (FileNotFoundException $e) {

        }
    }
}
