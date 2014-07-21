<?php

namespace spec\Netzmacht\Html\Element;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StaticHtmlSpec extends ObjectBehavior
{
	const HTML = '<b>Test</b>';

	function let()
	{
		$this->beConstructedWith(static::HTML);
	}

    function it_is_initializable()
    {
        $this->shouldHaveType('Netzmacht\Html\Element\StaticHtml');
    }

	function it_casts_to_string()
	{
		$this->shouldHaveType('Netzmacht\Html\CastsToString');
		$this->generate()->shouldReturn(static::HTML);
		$this->__toString()->shouldReturn(static::HTML);
	}

	function it_is_mutable()
	{
		$html = '<strong>Test</strong>';

		$this->getHtml()->shouldReturn(static::HTML);
		$this->setHtml($html)->shouldReturn($this);
		$this->getHtml()->shouldReturn($html);
	}
}
