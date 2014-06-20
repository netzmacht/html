<?php

namespace spec\Netzmacht\Html\Factory;

use Netzmacht\Html\Element;
use Netzmacht\Html\Factory\SimpleFactory;
use PhpSpec\ObjectBehavior;

class SimpleFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
		$this->shouldHaveType('Netzmacht\Html\Factory');
        $this->shouldHaveType('Netzmacht\Html\Factory\SimpleFactory');
    }


	function it_creates_element_with_tag()
	{
		$this->createElement('p')->shouldHaveType('Netzmacht\Html\Element');
		$this->createElement('p')->getTag()->shouldBe('p');
	}

	function it_accepts_attributes()
	{
		$attributes = array('class' => array('bar'), 'id' => 'foo');
		$this->createElement('p', $attributes)->getAttributes()->shouldReturn($attributes);
	}

	function it_creates_node()
	{
		$this->createElement('p')->shouldHaveType('Netzmacht\Html\Element\Node');
	}

	function it_creates_standalone()
	{
		$this->createElement('img')->shouldHaveType('Netzmacht\Html\Element\Standalone');
	}

	function it_accepts_standalone_config()
	{
		$standalone = array('p');

		$this->createElement('p')->shouldHaveType('Netzmacht\Html\Element\Node');
		$this->setStandalone($standalone);
		$this->createElement('p')->shouldHaveType('Netzmacht\Html\Element\Standalone');
	}

	function it_returns_current_standalone_config()
	{
		$standalone = array('p');

		$this->setStandalone(array('p'));
		$this->getStandalone()->shouldReturn($standalone);
	}

	function it_has_global_standalone_config()
	{
		$standalone = array('p');

		SimpleFactory::setStandalone($standalone);
		$this->getStandalone()->shouldReturn($standalone);
	}
}
