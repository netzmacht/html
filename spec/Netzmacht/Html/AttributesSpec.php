<?php

namespace spec\Netzmacht\Html;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AttributesSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Netzmacht\Html\Attributes');
		$this->shouldHaveType('Netzmacht\Html\GenerateInterface');
		$this->shouldHaveType('ArrayAccess');
		$this->shouldHaveType('IteratorAggregate');
    }


	function it_can_be_constructed_with_attributes()
	{
		$attributes = array('id' => 'my_id', 'class' => array('1', '2'));
		$this->beConstructedWith($attributes);

		$this->toArray()->shouldBeLike($attributes);
	}

	/**
	 *
	 */
	function it_sets_attribute_by_name()
	{
		$this->setAttribute('test', 'value')->shouldReturn($this);
		$this->getAttribute('test')->shouldReturn('value');
		$this->hasAttribute('test')->shouldReturn(true);
	}

	function it_gets_attribute_by_name()
	{
		$this->beConstructedWith(array('id' => 'test'));
		$this->getAttribute('id')->shouldReturn('test');
	}

	function it_gets_default_for_non_existing_attribute()
	{
		$this->getAttribute('test', 'val')->shouldReturn('val');
	}

	function it_gets_null_for_non_existing_attribute()
	{
		$this->getAttribute('test')->shouldReturn(null);
	}

	function its_rendered_by___toString()
	{
		$this->__toString()->shouldReturn($this->generate());
	}

	function it_renders_key_value_string()
	{
		$this->beConstructedWith(array('id' => 'my_id', 'class' => array('a', 'b')));

		$this->generate()->shouldReturn('class="a b" id="my_id"');
	}

	function it_encodes_html_entities()
	{
		$this->setAttribute('name', '""');
		$this->generate()->shouldReturn('name="&quot;&quot;"');
	}

	function it_throws_when_invalid_attribute_name_is_given()
	{
		$this
			->shouldThrow('Netzmacht\Html\Exception\InvalidArgumentException')
			->during('setAttribute', array('test"', 'val'));
	}


	function it_throws_when_constructed_with_invalid_attribute_name()
	{
		$this
			->shouldThrow('Netzmacht\Html\Exception\InvalidArgumentException')
			->during('__construct', array(array('test"' => 'val')));
	}
	
	function it_handles_html5_boolean_attributes()
	{
		$attributes = array(
			'compact'        => true,
			'declare'        => true,
			'defer'          => true,
			'disabled'       => true,
			'formnovalidate' => true,
			'multiple'       => true,
			'nowrap'         => true,
			'novalidate'     => true,
			'ismap'          => true,
			'readonly'       => true,
			'required'       => true,
			'selected'       => true
		);

		$this->beConstructedWith($attributes);

		$this->generate()->shouldReturn(implode(' ', array_keys($attributes)));
	}

	function it_ignores_false_html5_boolean_attributes()
	{
		$attributes = array(
			'compact'        => false,
			'declare'        => true,
			'defer'          => true,
			'disabled'       => true,
			'formnovalidate' => true,
			'multiple'       => false,
			'nowrap'         => true,
			'novalidate'     => true,
			'ismap'          => false,
			'readonly'       => true,
			'required'       => true,
			'selected'       => true
		);

		$this->beConstructedWith($attributes);

		$this->generate()->shouldReturn(implode(' ', array_keys(array_filter($attributes))));
	}
}
