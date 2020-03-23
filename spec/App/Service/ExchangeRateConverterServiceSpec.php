<?php

namespace spec\App\Service;

use App\Service\ExchangeRateConverterService;
use PhpSpec\ObjectBehavior;

class ExchangeRateConverterServiceSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ExchangeRateConverterService::class);
    }

    function it_should_correctly_convert_a_valid_amount()
    {
        $this->convert(3.00, 2.00)->shouldReturn(6.00);
    }
}
