<?php

namespace App\Service\Interfaces;

use Doctrine\Common\Collections\ArrayCollection;

interface ParserInterface
{
    public function parse(string $xmlFilePath): ArrayCollection;
}
