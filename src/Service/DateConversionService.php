<?php

namespace App\Service;

class DateConversionService
{
    /**
     * @param string $dateString
     * @return \DateTime
     */
    public static function convert(string $dateString): \DateTime
    {
        return \DateTime::createFromFormat('m/d/Y', $dateString);
    }
}
