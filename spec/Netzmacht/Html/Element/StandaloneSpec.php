<?php

namespace spec\Netzmacht\Html\Element;

use Netzmacht\Html\Element\Node;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StandaloneSpec extends ObjectBehavior
{
	private $attributes = array('class' => array('example'), 'src' => 'file.png');


	function let()
	{
		$this->beConstructedWith('img', $this->attributes);
	}


    function it_is_initializable()
    {
		$this->shouldHaveType('Netzmacht\Html\Element');
        $this->shouldHaveType('Netzmacht\Html\Element\Standalone');
    }


	function it_has_attributes()
	{
		$this->shouldHaveType('Netzmacht\Html\Attributes');
	}

	function it_generates_attribute()
	{
		$this->generateAttributes()->shouldReturn('class="example" src="file.png"');
	}


	function it_has_a_tag()
	{
		$this->getTag()->shouldReturn('img');
	}


	function it_creates_new_element()
	{
		$this->create('p')->shouldHaveType('Netzmacht\Html\Element');
	}


	function it_casts_to_string()
	{
		$this->generate()->shouldReturn('<img class="example" src="file.png">' . PHP_EOL);
	}

	function it_is_appendable(Node $parent)
	{
		$parent->addChild($this, Argument::any())->shouldBeCalled();

		$this->appendTo($parent)->shouldReturn($this);
	}

	function it_is_appendable_to_position(Node $parent)
	{
		$parent->addChild($this, Node::POSITION_FIRST)->shouldBeCalled();

		$this->appendTo($parent, Node::POSITION_FIRST)->shouldReturn($this);
	}

}
