<?php

namespace spec\Netzmacht\Html;

use PhpSpec\ObjectBehavior;

class AttributesSpec extends ObjectBehavior
{
	const EXCEPTION = 'Netzmacht\Html\Exception\InvalidArgumentException';

	function it_is_initializable()
    {
        $this->shouldHaveType('Netzmacht\Html\Attributes');
    }


	function it_can_be_constructed_with_attributes()
	{
		$attributes = array('id' => 'my_id', 'class' => array('a', 'b'));
		$this->beConstructedWith($attributes);

		$this->getAttributes()->shouldBeLike($attributes);
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
		$this->shouldHaveType('Netzmacht\Html\CastsToString');
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
			->shouldThrow(self::EXCEPTION)
			->during('setAttribute', array('test"', 'val'));
	}


	function it_throws_when_constructed_with_invalid_attribute_name()
	{
		$this
			->shouldThrow(self::EXCEPTION)
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


	function it_iterates_through_attributes()
	{
		$attributes = array('id' => 'my_id', 'class' => array('a', 'b'));
		$this->beConstructedWith($attributes);

		$this->shouldHaveType('IteratorAggregate');
		$this->getIterator()->shouldBeAnInstanceOf('\Traversable');
		$this->getIterator()->getArrayCopy()->shouldBeLike($attributes);
	}


	function it_adds_multiple_attributes()
	{
		$attributes = array('id' => 'my_id', 'class' => array('a', 'b'));

		$this->addAttributes($attributes)->shouldReturn($this);
		$this->getAttributes()->shouldBeLike($attributes);
	}

	function it_removes_attribute()
	{
		$attributes = array('id' => 'my_id', 'class' => array('a', 'b'));
		$this->beConstructedWith($attributes);

		$this->hasAttribute('id')->shouldBe(true);
		$this->removeAttribute('id')->shouldReturn($this);
		$this->hasAttribute('id')->shouldBe(false);
	}

	function it_stores_classes_as_array()
	{
		$this->getAttribute('class')->shouldBeArray();
	}

	function it_keeps_empty_attributes_array_when_removed()
	{
		$this->removeAttribute('class');
		$this->getAttribute('class')->shouldBeArray();
		$this->getAttribute('class')->shouldHaveCount(0);
	}

	function it_throws_when_class_is_a_string()
	{
		$this
			->shouldThrow(static::EXCEPTION)
			->during('setAttribute', array('class', 'foo'));
	}

	function it_adds_a_class()
	{
		$this->addClass('foo')->shouldReturn($this);
		$this->getAttribute('class')->shouldBeLike(array('foo'));
	}

	function it_splits_multiple_classes()
	{
		$this->addClass('foo bar')->shouldReturn($this);
		$this->getAttribute('class')->shouldBeLike(array('foo', 'bar'));
	}

	function it_accepts_a_valid_css_class()
	{
		$this->addClass('-moz-padding-foo');
		$this->addClass('foo');
		$this->addClass('_foo_bar');
		$this->addClass('-_foo_bar');
	}

	function it_ignores_empty_css_class()
    {
        $this->addClass('test');
        $this->getAttribute('class')->shouldReturn(array('test'));
        $this->addClass('');
        $this->getAttribute('class')->shouldReturn(array('test'));
    }

	function it_removes_class()
	{
		$attributes = array('id' => 'my_id', 'class' => array('a', 'b'));
		$this->beConstructedWith($attributes);

		$this->hasClass('a')->shouldBe(true);
		$this->removeClass('a')->shouldReturn($this);
		$this->hasClass('a')->shouldBe(false);
	}

	function it_gets_id()
	{
		$attributes = array('id' => 'my_id', 'class' => array('a', 'b'));
		$this->beConstructedWith($attributes);

		$this->getId()->shouldBe('my_id');
	}

	function it_sets_id()
	{
		$this->setId('foo')->shouldReturn($this);
		$this->getId()->shouldBe('foo');
	}

	function it_has_array_access()
	{
		$attributes = array('id' => 'my_id', 'class' => array('a', 'b'));
		$this->beConstructedWith($attributes);

		$this->shouldHaveType('ArrayAccess');

		$this['id']->shouldBe('my_id');
		$this['id'] = 'foo';
		$this['id']->shouldBe('foo');
	}

	function it_validates_array_access_value()
	{
		$this->shouldThrow(static::EXCEPTION)->during('offsetSet', array('class', ':hide'));
	}

	function it_validates_array_access_key()
	{
		$this->shouldThrow(static::EXCEPTION)->during('offsetSet', array('"class', 'hans'));
	}
}
