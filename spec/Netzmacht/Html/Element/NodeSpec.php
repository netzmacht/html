<?php

namespace spec\Netzmacht\Html\Element;

use Netzmacht\Html\Element\Node;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NodeSpec extends ObjectBehavior
{
	private $attributes = array('class' => array('example'), 'id' => 'test');

	function let()
	{
		$this->beConstructedWith('p', $this->attributes);
	}

    function it_is_initializable()
    {
		$this->shouldHaveType('Netzmacht\Html\Element');
        $this->shouldHaveType('Netzmacht\Html\Element\Node');
    }

	function it_has_attributes()
	{
		$this->shouldHaveType('Netzmacht\Html\Attributes');
	}

	function it_generates_attribute()
	{
		$this->generateAttributes()->shouldReturn('class="example" id="test"');
	}

	function it_creates_new_element()
	{
		$this->create('p')->shouldHaveType('Netzmacht\Html\Element');
	}

	function it_casts_to_string()
	{
		$this->generate()->shouldReturn('<p class="example" id="test"></p>' . PHP_EOL);
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

	function it_adds_child(Node $child)
	{
		$this->addChild($child)->shouldReturn($this);
		$this->getChildren()->shouldReturn(array($child));
	}

	function it_adds_childen(Node $child, Node $childB)
	{
		$children = array($child, $childB);

		$this->addChildren($children)->shouldReturn($this);
		$this->getChildren()->shouldReturn($children);
	}

	function it_gets_child_position(Node $child, Node $childB)
	{
		$this->addChild($child);

		$this->getChildPosition($child)->shouldReturn(0);
	}

	function it_returns_false_if_element_is_not_a_child(Node $child)
	{
		$this->getChildPosition($child)->shouldReturn(false);
	}

	function it_adds_child_by_position(Node $a, Node $b, Node $c)
	{
		$this
			->addChild($a)
			->addChild($b, Node::POSITION_FIRST)
			->addChild($c, 1);

		$this->getChildPosition($a)->shouldBe(2);
		$this->getChildPosition($b)->shouldBe(0);
		$this->getChildPosition($c)->shouldBe(1);
	}

	function it_creates_child()
	{
		$this->createChild('p');
		$children = $this->getChildren();
		$children[0]->getTag('p')->shouldReturn('p');
	}

	function it_creates_child_at_position(Node $a, Node $b, Node $c)
	{
		$this->addChildren(array($a, $b, $c));
		$this->createChild('p', array(), Node::POSITION_FIRST);

		$children = $this->getChildren();
		$children[0]->getTag('p')->shouldReturn('p');
	}

	function it_gets_children(Node $a)
	{
		$this->addChild($a);

		$this->getChildren()->shouldReturn(array($a));
	}

	function it_removes_child(Node $a)
	{
		$this->addChild($a);
		$this->getChildren()->shouldReturn(array($a));

		$this->removeChild($a);
		$this->getChildren()->shouldReturn(array());
	}

	function it_removes_all_children(Node $a)
	{
		$this->addChild($a);
		$this->getChildren()->shouldReturn(array($a));

		$this->removeChildren()->shouldReturn($this);
		$this->getChildren()->shouldReturn(array());
	}

	function it_renders_content(Node $a)
	{
		$content = '<a href="#test">Test</a>';
		$a->generate()->willReturn($content);
		$a->__toString()->willReturn($content);

		$this->getContent()->shouldBe('');

		$this->addChild($a);
		$this->getContent()->shouldBe($content);
	}

	function it_casts_to_string_contains_content(Node $a)
	{
		$content = '<a href="#test">Test</a>';
		$a->generate()->willReturn($content);
		$a->__toString()->willReturn($content);

		$this->addChild($a);
		$this->generate()->shouldReturn('<p class="example" id="test">' . $content . '</p>' . PHP_EOL);
	}
}
